<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_can_be_created_updated_and_deleted(): void
    {
        $attributes = [
            'produk' => 'Pensil warna',
            'harga' => 12000,
            'keuntungan' => 3000,
            'terjual' => 8,
        ];

        $this->post(route('products.store'), $attributes)->assertRedirect(route('products.index'));
        $product = Product::query()->firstOrFail();
        $this->assertSame('Pensil warna', $product->produk);

        $updatedAttributes = [...$attributes, 'produk' => 'Pensil warna 12 pcs'];
        $this->put(route('products.update', $product), $updatedAttributes)
            ->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'produk' => 'Pensil warna 12 pcs']);

        $this->delete(route('products.destroy', $product))->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_fields_are_validated(): void
    {
        $this->from(route('products.index'))
            ->post(route('products.store'), [
                'produk' => '',
                'harga' => -1,
                'keuntungan' => 'bukan angka',
                'terjual' => -2,
            ])
            ->assertSessionHasErrors(['produk', 'harga', 'keuntungan', 'terjual']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_index_renders_products_and_database_summary(): void
    {
        $this->seed(ProductSeeder::class);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Pensil 2B')
            ->assertSee('Total Unit Terjual')
            ->assertSee('database MySQL')
            ->assertSee('bubbleChartPenjualanProduk');
    }

    public function test_reset_restores_thirty_seed_products(): void
    {
        Product::query()->create([
            'produk' => 'Produk sementara',
            'harga' => 1,
            'keuntungan' => 0,
            'terjual' => 0,
        ]);

        $this->post(route('products.reset'))->assertRedirect(route('products.index'));

        $this->assertDatabaseCount('products', 30);
        $this->assertDatabaseHas('products', ['produk' => 'Pensil 2B']);
        $this->assertDatabaseMissing('products', ['produk' => 'Produk sementara']);
    }

    public function test_product_seeder_creates_thirty_products(): void
    {
        $this->seed(ProductSeeder::class);

        $this->assertDatabaseCount('products', 30);
    }
}
