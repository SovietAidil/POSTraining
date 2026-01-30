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
        // goods_issuance_items
        if (Schema::hasColumn('goods_issuance_items', 'receipt_number')) {
            Schema::table('goods_issuance_items', function (Blueprint $table) {
                $table->renameColumn('receipt_number', 'issuance_number');
            });
        }

        // goods_issuances
        if (Schema::hasColumn('goods_issuances', 'receipt_number')) {
            Schema::table('goods_issuances', function (Blueprint $table) {
                $table->renameColumn('receipt_number', 'issuance_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // goods_issuance_items
        if (Schema::hasColumn('goods_issuance_items', 'issuance_number')) {
            Schema::table('goods_issuance_items', function (Blueprint $table) {
                $table->renameColumn('issuance_number', 'receipt_number');
            });
        }

        // goods_issuances
        if (Schema::hasColumn('goods_issuances', 'issuance_number')) {
            Schema::table('goods_issuances', function (Blueprint $table) {
                $table->renameColumn('issuance_number', 'receipt_number');
            });
        }
    }
};
