<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_code')->unique();
            $table->string('product_name');
            $table->string('size')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->string('status')->default('Sedang Diproses');
            $table->string('image')->nullable();
            $table->date('order_date');
            $table->decimal('total_payment', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};