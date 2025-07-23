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
            $table->string('product_name');
            $table->bigInteger('product_price');
            $table->bigInteger('promo')->nullable();
            $table->string('short_description');
            $table->text('full_description');
            $table->string('product_status')->nullable();
            $table->json('marketplaces')->nullable();
            $table->string('special_order_link')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->json('special_payment_method')->nullable();
            $table->longText('response_output');
            $table->json('product_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
