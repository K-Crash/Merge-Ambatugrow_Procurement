<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('requisition_id')->nullable()->constrained('requisitions')->nullOnDelete();
            $table->string('status')->default('draft'); // draft, sent, confirmed, delivered, cancelled
            $table->decimal('total', 14, 2)->default(0);
            $table->date('expected_delivery')->nullable();
            $table->timestamp('issued_at')->nullable();
            
            // Columns added for Supplier Management compatibility
            $table->foreignId('payment_term_id')->nullable()->constrained('payment_terms')->cascadeOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->dateTime('order_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
