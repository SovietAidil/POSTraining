<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'product_name',
        'sale_price',
        'original_purchase_price',
        'category_id',
        'stock',
        'minimum_stock',
        'is_active',
    ];
    public static function numberSku(){
        // SKU-00001
        $prefix = 'SKU-';
        $maxId = self::max('id') ?? 0;
        $sku = $prefix . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);
        return $sku;
    }
}
