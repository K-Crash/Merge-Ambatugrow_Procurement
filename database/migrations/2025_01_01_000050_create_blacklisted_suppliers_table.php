<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blacklisted_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('supplier_code')->nullable();
            $table->string('reason');
            $table->date('blacklisted_since');
            $table->string('risk_level'); // Low | Medium | High | Critical
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blacklisted_suppliers');
    }
};
