<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending')->after('payment_proof');
            }
            if (!Schema::hasColumn('orders', 'order_status')) {
                $table->enum('order_status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending')->after('payment_status');
            }
        });
    }
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_status')) {
                $table->dropColumn('order_status');
            }
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('orders', 'payment_proof')) {
                $table->dropColumn('payment_proof');
            }
        });
    }
};
