<?php

namespace App\Imports;

use App\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'parent_category_id' => $row[0],
            'code' => $row[1],
            'name' => $row[2],
            'note' => $row[3]
        ]);
    }
}
