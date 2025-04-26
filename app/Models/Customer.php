<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name', 'gender', 'phone_number', 'address'
    ];

    public function orderGroups(): HasMany
    {
        return $this->hasMany(OrderGroup::class, 'order_group_id', 'order_group_id');
    }
}
