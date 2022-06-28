<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiImg extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    // in MultiImage table, match product_id with Products table id
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}