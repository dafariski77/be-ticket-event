<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function search_event(Request $request)
    {
        $keyword = $request->query('name');

        $result = Event::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%'])->get();

        if ($result->isEmpty()) {
            return response()->json([
                "message" => "Event not found!",
            ]);
        }

        return response()->json([
            "message" => "Event found!",
            "data" => $result
        ], Response::HTTP_OK);
    }
}
