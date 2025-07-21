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
            $table->decimal('total_price', 8, 2);
            $table->decimal('pay_amount', 8, 2);
            $table->decimal('change_amount', 8, 2);
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
