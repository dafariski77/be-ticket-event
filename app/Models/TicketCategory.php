<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = [
        'name',
        'price',
        'event_id'
    ];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
