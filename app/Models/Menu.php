<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name', 'price'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id');
    }
}
