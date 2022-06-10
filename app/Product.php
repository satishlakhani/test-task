<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'unit_id',
        'product_type_id',
        'code',
        'name',
        'barcode',
        'has_limit',
        'note'
    ];
}
