<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->orderBy('id')->get();

        return view('products.index', [
            'products' => $products,
            'chartProducts' => $products->map(static fn (Product $product): array => [
                'name' => $product->produk,
                'price' => $product->harga,
                'profit' => $product->keuntungan,
                'sold' => $product->terjual,
            ])->values(),
            'totalProduk' => $products->count(),
            'totalTerjual' => $products->sum('terjual'),
            'totalKeuntungan' => $products->sum('keuntungan'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::query()->create($this->validatedProduct($request));

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedProduct($request));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function reset(): RedirectResponse
    {
        DB::transaction(function (): void {
            Product::query()->delete();
            app(ProductSeeder::class)->run();
        });

        return redirect()->route('products.index')->with('success', 'Data produk dikembalikan ke 30 data awal.');
    }

    /**
     * @return array{produk: string, harga: int, keuntungan: int, terjual: int}
     */
    private function validatedProduct(Request $request): array
    {
        return $request->validate([
            'produk' => ['required', 'string', 'max:80'],
            'harga' => ['required', 'integer', 'min:0'],
            'keuntungan' => ['required', 'integer', 'min:0'],
            'terjual' => ['required', 'integer', 'min:0'],
        ]);
    }
}
