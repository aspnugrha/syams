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
        Schema::table('products', function (Blueprint $table) {
            $table->text('bordir')->nullable();
            $table->text('input_settings')->nullable();
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->text('bordir_selected')->nullable();
            $table->string('custom_packaging', 30)->nullable();
            $table->string('custom_label', 30)->nullable();
            $table->string('custom_metal', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
