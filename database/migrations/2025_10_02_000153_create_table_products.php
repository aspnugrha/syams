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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('type', 50)->default('SHOWCASE')->comment('SHOWCASE/ORDER');
            $table->string('category_id', 50)->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->string('slug', 150)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('cover', 50)->nullable();
            $table->text('image')->nullable();
            $table->text('size_qty_options')->nullable();
            $table->text('material_color_options')->nullable();
            $table->text('sablon_type')->nullable();
            $table->tinyInteger('is_bordir')->default(0)->comment('1=YES,0=NO');
            $table->tinyInteger('active')->default(0)->comment('1=active,0=nonactive');
            $table->tinyInteger('main_product')->default(0);
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
        Schema::dropIfExists('products');
    }
};
