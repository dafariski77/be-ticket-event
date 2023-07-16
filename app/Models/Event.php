<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'date',
        'about',
        'venue',
        'status',
        'image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ticket_category()
    {
        return $this->hasMany(TicketCategory::class);
    }
}
