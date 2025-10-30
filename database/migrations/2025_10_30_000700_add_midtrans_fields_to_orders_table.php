<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway')->nullable()->after('payment_method');
            $table->string('payment_token')->nullable()->after('payment_gateway');
            $table->string('payment_redirect_url')->nullable()->after('payment_token');
            $table->string('payment_transaction_id')->nullable()->after('payment_redirect_url');
            $table->string('payment_status')->nullable()->after('status');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_token',
                'payment_redirect_url',
                'payment_transaction_id',
                'payment_status',
                'paid_at',
            ]);
        });
    }
};




