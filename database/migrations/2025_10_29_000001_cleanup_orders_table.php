<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'product_name')) {
                $table->dropColumn('product_name');
            }
            if (Schema::hasColumn('orders', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('orders', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('orders', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('orders', 'order_date')) {
                $table->dropColumn('order_date');
            }
            if (Schema::hasColumn('orders', 'total_payment')) {
                $table->dropColumn('total_payment');
            }
        });

        // Tambahan migrasi untuk payment
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable();
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('orders', 'order_status')) {
                $table->enum('order_status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'product_name')) {
                $table->string('product_name')->nullable();
            }
            if (!Schema::hasColumn('orders', 'size')) {
                $table->string('size')->nullable();
            }
            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->nullable();
            }
            if (!Schema::hasColumn('orders', 'price')) {
                $table->decimal('price', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('orders', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('orders', 'order_date')) {
                $table->date('order_date')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_payment')) {
                $table->decimal('total_payment', 12, 2)->nullable();
            }
        });
    }
};



