<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand_name_en',
        'brand_name_cn',
        'brand_slug_en',
        'brand_slug_cn',
        'category_icon',
    ];
}