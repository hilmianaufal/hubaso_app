<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->integer('bayar')
                  ->nullable()
                  ->after('total');

            $table->integer('kembalian')
                  ->nullable()
                  ->after('bayar');

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'bayar',
                'kembalian'
            ]);

        });
    }
};
