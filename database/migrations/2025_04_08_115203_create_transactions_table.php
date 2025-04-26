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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('order_group_id')->constrained(
                table: 'order_groups', indexName: 'transactions_order_group_id'
            )->references('order_group_id')->onDelete('cascade');
            $table->integer('total_price');
            $table->integer('pay_amount');
            $table->integer('change_amount');
            $table->boolean('transaction_status')->default(false);
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'transactions_user_id'
            )->references('user_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
