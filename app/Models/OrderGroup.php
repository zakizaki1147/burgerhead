<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_group_id';

    protected $fillable = [
        'customer_id', 'table_id', 'user_id', 'order_status'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_group_id', 'order_group_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'table_id', 'table_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'transaction_id', 'transaction_id');
    }
}
