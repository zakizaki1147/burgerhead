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
            $table->id('order_id');
            $table->foreignId('order_group_id')->constrained(
                table: 'order_groups', indexName: 'orders_order_group_id'
            )->references('order_group_id')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained(
                table: 'menus', indexName: 'orders_menu_id'
            )->references('menu_id')->onDelete('cascade');
            $table->integer('menu_amount');
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
