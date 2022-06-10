<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Import category CSV file.
     */
    public function fileImport(Request $request)
    {
        // Reading file
        $file = fopen(public_path('csv/categories.csv'), "r");
        $importData_arr = array(); // Read through the file and store the contents as an array
        $i = 0;
        //Read the contents of the uploaded file
        while (($filedata = fgetcsv($file, 100, ",")) !== false)
        {
            $num = count($filedata);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0)
            {
                $i++;
                continue;
            }
            for ($c = 0;$c < $num;$c++)
            {
                $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
            if($i >= 100)
                break;
        }
        fclose($file); //Close after reading
        foreach ($importData_arr as $importData)
        {
            try
            {

                $category = Category::create([
                    'parent_category_id' => (!empty($importData[0])) ? ($importData[0]) : null,
                    'name' => $importData[1],
                    'note' => $importData[2]
                ]);
                $category->code = '00' . $category->id;
                $category->save();
            }
            catch(\Exception $e)
            {
                return back()->with('error',$e->getMessage());
            }
        }
        return back()->with('success', 'Category has imported successfully');;
    }

}
