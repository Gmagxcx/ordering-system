<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'product_id',
        'quantity_in_stock',
        'last_stock_update'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

