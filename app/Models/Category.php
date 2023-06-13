<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image'
    ];

    public static function validate($request)
    {
        $request->validate([
            "name" => "required|max:255",
            "image" => "image"
        ]);
    }
}
