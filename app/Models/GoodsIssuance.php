<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIssuance extends Model
{
    protected $guarded = ['id'];

    public static function issuanceNumber()
    {   // GIS-2001260001
        $maxId  = self::max('id');
        $prefix = 'GIS-';
        $number = $prefix . date('dmy') . str_pad($maxId + 1, 5,'0', STR_PAD_LEFT);
        return $number;
    }

    public function items(){
        return $this->hasMany(GoodsIssuanceItem::class,'issuance_number', 'issuance_number');
    }

}
