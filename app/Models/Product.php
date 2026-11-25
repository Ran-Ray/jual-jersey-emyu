<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'produk',
        'harga',
        'keuntungan',
        'terjual',
    ];
}
