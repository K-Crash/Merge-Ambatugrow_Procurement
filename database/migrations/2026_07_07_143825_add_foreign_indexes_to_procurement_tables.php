<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->index('purchase_order_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->index('purchase_order_id');
        });

        Schema::table('delivery_receipts', function (Blueprint $table) {
            $table->index('purchase_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->dropIndex(['purchase_order_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['purchase_order_id']);
        });

        Schema::table('delivery_receipts', function (Blueprint $table) {
            $table->dropIndex(['purchase_order_id']);
        });
    }
};
