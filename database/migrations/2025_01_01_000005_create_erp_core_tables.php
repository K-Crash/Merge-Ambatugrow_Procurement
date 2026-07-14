<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 255);
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('zipcode', 20);
            $table->string('country', 100);
            $table->timestamps();
        });

        Schema::create('units_of_measure', function (Blueprint $table) {
            $table->id();
            $table->string('uom_code', 10);
            $table->string('uom_name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_terms', function (Blueprint $table) {
            $table->id();
            $table->string('term_code', 20);
            $table->text('description')->nullable();
            $table->integer('net_days');
            $table->decimal('discount_percent', 5, 2);
            $table->timestamps();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->char('currency_code', 3);
            $table->string('currency_name', 50);
            $table->decimal('exchange_rate', 10, 4);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 100);
            $table->foreignId('parent_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('payment_terms');
        Schema::dropIfExists('units_of_measure');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('roles');
    }
};
