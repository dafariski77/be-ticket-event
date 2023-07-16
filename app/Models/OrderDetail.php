<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        "amount",
        "price",
        "event_id",
        "order_id",
        "ticket_id"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ticket()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
