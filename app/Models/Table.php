<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $primaryKey = 'table_id';

    protected $fillable = [
        'table_name', 'table_capacity', 'table_status'
    ];

    public function orderGroups(): HasMany
    {
        return $this->hasMany(OrderGroup::class, 'order_group_id', 'order_group_id');
    }
}
