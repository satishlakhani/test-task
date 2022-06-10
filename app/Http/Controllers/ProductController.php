<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Import prodcut CSV file.
     */
    public function fileImport()
    {
        // Reading file
        $file = fopen(public_path('csv/products.csv'), "r");
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
                $category = Category::select('id','code')->find($importData[0])->first();
                if($category){
                    $product = Product::create([
                        'category_id' => (!empty($importData[0])) ? ($importData[0]) : null,
                        'unit_id' => $importData[1],
                        'product_type_id' => $importData[2],
                        'name' => $importData[3],
                        'has_limit' => $importData[4],
                        'note' => $importData[5]
                    ]);
                    $product->code = $category->code.'00'.$product->id;
                    $product->barcode = $category->code.'00'.$product->id.'00'.$product->unit_id.$product->product_type_id;
                    $product->save();
                }
            }
            catch(\Exception $e)
            {
                return back()->with('error',$e->getMessage());
            }
        }
        return back()->with('success', 'Product has imported successfully');;
    }
}
