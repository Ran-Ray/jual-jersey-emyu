<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = ['tanggal_transaksi','kuantitas_penjualan'];
    
    protected function casts(): array{
        return ['tanggal_transaksi'=>'date','kuantitas_penjualan'=>'integer'];
    }
}
