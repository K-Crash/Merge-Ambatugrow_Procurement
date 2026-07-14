<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('dr_number')->unique();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->timestamp('received_at')->nullable();
            $table->json('items')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_receipts');
    }
}
