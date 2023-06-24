<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'name',
    ];

    public static function validate($request)
    {
        $request->validate([
            "name" => "required|max:255",
        ]);
    }
}
