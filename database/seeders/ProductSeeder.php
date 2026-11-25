<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = now();
        $dataAwal = [
            ['produk' => 'Pensil 2B', 'harga' => 3000, 'keuntungan' => 800, 'terjual' => 120],
            ['produk' => 'Pulpen Biru', 'harga' => 4000, 'keuntungan' => 1000, 'terjual' => 95],
            ['produk' => 'Penghapus', 'harga' => 2000, 'keuntungan' => 500, 'terjual' => 87],
            ['produk' => 'Penggaris 30 cm', 'harga' => 5000, 'keuntungan' => 1500, 'terjual' => 64],
            ['produk' => 'Buku Tulis 38 Lembar', 'harga' => 3500, 'keuntungan' => 900, 'terjual' => 110],
            ['produk' => 'Buku Gambar A4', 'harga' => 8000, 'keuntungan' => 2000, 'terjual' => 42],
            ['produk' => 'Buku Kotak-Kotak', 'harga' => 4500, 'keuntungan' => 1200, 'terjual' => 51],
            ['produk' => 'Buku Agenda', 'harga' => 18000, 'keuntungan' => 4500, 'terjual' => 25],
            ['produk' => 'Pensil Warna 12 Warna', 'harga' => 22000, 'keuntungan' => 5500, 'terjual' => 38],
            ['produk' => 'Krayon 12 Warna', 'harga' => 16000, 'keuntungan' => 4000, 'terjual' => 31],
            ['produk' => 'Spidol Warna', 'harga' => 12000, 'keuntungan' => 3000, 'terjual' => 46],
            ['produk' => 'Stabilo', 'harga' => 7000, 'keuntungan' => 1800, 'terjual' => 59],
            ['produk' => 'Rautan Pensil', 'harga' => 3500, 'keuntungan' => 900, 'terjual' => 70],
            ['produk' => 'Gunting Kecil', 'harga' => 9000, 'keuntungan' => 2200, 'terjual' => 28],
            ['produk' => 'Lem Kertas', 'harga' => 5000, 'keuntungan' => 1300, 'terjual' => 55],
            ['produk' => 'Lem Stik', 'harga' => 6500, 'keuntungan' => 1600, 'terjual' => 34],
            ['produk' => 'Kertas HVS  A4 (20 lembar)', 'harga' => 6000, 'keuntungan' => 1500, 'terjual' => 41],
            ['produk' => 'Kertas Origami', 'harga' => 7500, 'keuntungan' => 1900, 'terjual' => 36],
            ['produk' => 'Map Plastik', 'harga' => 4000, 'keuntungan' => 1000, 'terjual' => 63],
            ['produk' => 'Map Kertas', 'harga' => 2500, 'keuntungan' => 600, 'terjual' => 48],
            ['produk' => 'Kotak Pensil', 'harga' => 25000, 'keuntungan' => 6500, 'terjual' => 22],
            ['produk' => 'Tas Sekolah', 'harga' => 125000, 'keuntungan' => 25000, 'terjual' => 15],
            ['produk' => 'Tempat Minum', 'harga' => 35000, 'keuntungan' => 8500, 'terjual' => 19],
            ['produk' => 'Penggaris Segitiga', 'harga' => 7000, 'keuntungan' => 1800, 'terjual' => 27],
            ['produk' => 'Jangka', 'harga' => 14000, 'keuntungan' => 3500, 'terjual' => 18],
            ['produk' => 'Busur Derajat', 'harga' => 4500, 'keuntungan' => 1100, 'terjual' => 24],
            ['produk' => 'Kalkulator Saku', 'harga' => 45000, 'keuntungan' => 10000, 'terjual' => 12],
            ['produk' => 'Penggaris Besi', 'harga' => 10000, 'keuntungan' => 2500, 'terjual' => 17],
            ['produk' => 'Tipe-X', 'harga' => 6000, 'keuntungan' => 1500, 'terjual' => 33],
            ['produk' => 'Stapler Mini', 'harga' => 12000, 'keuntungan' => 3000, 'terjual' => 14],
        ];

        DB::table('products')->insert(array_map(
            static fn (array $product): array => [
                ...$product,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            $dataAwal,
        ));
    }
}
