<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // PR-2024-00125
            $table->string('title');
            $table->string('department')->nullable();
            $table->foreignId('requestor_id')->constrained('users')->cascadeOnDelete();
            $table->date('needed_by')->nullable();
            $table->text('purpose')->nullable();
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0); // percentage
            $table->decimal('tax_amount', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->enum('approval_type', ['sequential', 'parallel'])->default('sequential');
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'rejected'])->default('draft');
            $table->string('urgency')->default('Medium'); // Low, Medium, High
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
