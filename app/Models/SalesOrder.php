<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SalesOrderItem;

class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 'sales_orders';

    protected $fillable = ['customer_name', 'total', 'is_confirmed'];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}

