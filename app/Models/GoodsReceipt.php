<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $guarded = ['id'];

    public static function receiptNumber(){
        // GDR-2001260001
        $max = self::max('id');
        $prefix = 'GDR-';
        $date = date('dmy');
        $number = $prefix . $date . str_pad($max + 1,4,  '0', STR_PAD_LEFT);
        return $number;
    }

    public function items(){
        return $this->hasMany(GoodsReceiptItem::class, 'receipt_number', 'receipt_number');
    }


}
