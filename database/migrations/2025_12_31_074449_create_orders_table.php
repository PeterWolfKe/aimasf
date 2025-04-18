<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('apartment_suite')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->string('phone')->nullable(); // required since 2025-04-19
            $table->string('shipping_option_id');

            $table->json('products')->nullable();
            $table->string('unique_order_id')->unique();
            $table->string('note', 1000)->nullable();

            $table->string('ico')->nullable();
            $table->string('dic')->nullable();

            $table->integer('status')->default('0');
            $table->boolean('mail_sended')->default(false);
            $table->string('ip_address');
            $table->string('discount_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
