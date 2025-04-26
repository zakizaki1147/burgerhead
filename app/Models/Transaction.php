<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'order_group_id', 'total_price', 'pay_amount', 'change_amount', 'transaction_status', 'user_id'
    ];

    public function orderGroup(): BelongsTo
    {
        return $this->belongsTo(OrderGroup::class, 'order_group_id', 'order_group_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
