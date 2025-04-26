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
        Schema::create('order_groups', function (Blueprint $table) {
            $table->id('order_group_id');
            $table->foreignId('customer_id')->constrained(
                table: 'customers', indexName: 'order_groups_customer_id'
            )->references('customer_id')->onDelete('cascade');
            $table->foreignId('table_id')->constrained(
                table: 'tables', indexName: 'order_groups_table_id'
            )->references('table_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'order_groups_user_id'
            )->references('user_id')->onDelete('cascade');
            $table->boolean('order_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_groups');
    }
};
