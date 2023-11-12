<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 100)->default('untitled');
            $table->string('product_description', 100)->nullable()->default(null);
            $table->string('product_image', 100)->nullable()->default(null);
            $table->integer('quantity')->default(0);
            $table->float('tax', 8, 2)->default(0);
            $table->float('price_box_listing', 20, 2)->default(0);
            $table->float('price_box_discounted', 20, 2)->default(0);
            $table->float('price_item_listing', 20, 2)->default(0);
            $table->float('price_item_discounted', 20, 2)->default(0);
            $table->integer('limit_by_age')->default(0);
            $table->integer('limit_per_order')->default(0);
            $table->string('SKU', 100)->nullable()->default(null);
            $table->string('barcode', 100)->nullable()->default(null);
            $table->timestamps();
        });

        // generate 10 fake products
        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
                'product_name' => 'Product ' . $i,
                'product_description' => 'Product ' . $i . ' description',
                'product_image' => 'https://picsum.photos/200/300',
                'quantity' => rand(0, 100),
                'tax' => rand(0, 100),
                'price_box_listing' => rand(0, 100),
                'price_box_discounted' => rand(0, 100),
                'price_item_listing' => rand(0, 100),
                'price_item_discounted' => rand(0, 100),
                'limit_by_age' => 2*$i,
                'limit_per_order' => 2*$i,
                'SKU' => 'SKU' . $i,
                'barcode' => 'barcode' . $i,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
