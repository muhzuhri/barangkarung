<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('payment_settings')) {
            return;
        }

        if (DB::table('payment_settings')->count() === 0) {
            DB::table('payment_settings')->insert([
                [
                    'payment_method' => 'transfer_bca',
                    'label' => 'Transfer BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Nama Pemilik Rekening',
                    'icon_image' => null,
                    'qris_image' => null,
                    'instructions' => 'Silakan transfer ke rekening di atas lalu upload bukti pembayaran.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('payment_settings')) {
            return;
        }

        DB::table('payment_settings')
            ->where('payment_method', 'transfer_bca')
            ->delete();
    }
};


