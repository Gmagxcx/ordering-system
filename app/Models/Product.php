<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'available_quantity',
        'category',
        'image'
    ];

    // Relationships
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }


    public function inventories()
    {
        return $this->hasOne(Inventory::class);
    }
    
}