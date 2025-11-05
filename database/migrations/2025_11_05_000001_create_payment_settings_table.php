<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->unique(); // dana, mandiri, qris, dll
            $table->string('label')->nullable(); // Label untuk ditampilkan
            $table->string('account_number')->nullable(); // Nomor rekening/nomor
            $table->string('account_name')->nullable(); // Nama pemilik
            $table->string('qris_image')->nullable(); // Path gambar QRIS
            $table->text('instructions')->nullable(); // Instruksi pembayaran
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};

