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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('order_number', 50)->unique();
            $table->string('order_type', 50);
            $table->dateTime('order_date');
            $table->string('customer_id', 100)->nullable();
            $table->string('customer_name', 100);
            $table->string('customer_email', 100)->nullable();
            $table->string('customer_phone_number', 100);
            $table->text('notes')->nullable();
            $table->string('status', 100)->default('PENDING')->comment('PENDING,APPROVED,CANCELED');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->string('canceled_by_customer', 50)->nullable();
            $table->foreign('canceled_by_customer')->references('id')->on('customers')->onDelete('set null');
            $table->string('canceled_by', 50)->nullable();
            $table->foreign('canceled_by')->references('id')->on('users')->onDelete('set null');
            $table->string('created_by_customer', 50)->nullable();
            $table->foreign('created_by_customer')->references('id')->on('customers')->onDelete('set null');
            $table->string('updated_by_customer', 50)->nullable();
            $table->foreign('updated_by_customer')->references('id')->on('customers')->onDelete('set null');
            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->string('updated_by', 50)->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
        
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('order_id', 50);
            $table->string('product_id', 50);
            $table->string('product_name', 50);
            $table->string('product_category', 50)->nullable();
            $table->string('product_image', 50)->nullable();
            $table->string('size_selected', 50);
            $table->string('qty_selected', 50);
            $table->text('notes')->nullable();
            $table->string('status', 100)->default('PENDING')->comment('PENDING,APPROVED,CANCELED');
            $table->string('created_by_customer', 50)->nullable();
            $table->foreign('created_by_customer')->references('id')->on('customers')->onDelete('set null');
            $table->string('updated_by_customer', 50)->nullable();
            $table->foreign('updated_by_customer')->references('id')->on('customers')->onDelete('set null');
            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->string('updated_by', 50)->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
