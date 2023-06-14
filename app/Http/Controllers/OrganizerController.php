<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizer = User::where('role', '=', 'organizer')->get();

        return response()->json([
            "message" => "Success get all organizer data!",
            "data" => $organizer
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::validate($request);

        if ($request->password !== $request->confirmPassword) {
            return response()->json([
                "message" => "Invalid Password!"
            ], Response::HTTP_BAD_REQUEST);
        }

        $email = User::firstWhere("email", $request->email);

        if ($email) {
            return response()->json([
                "message" => "Email already registered!"
            ], Response::HTTP_BAD_REQUEST);
        }

        $organizer = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => "organizer"
        ]);

        return response([
            "message" => "Organizer Registered!",
            "data" => $organizer
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organizer = User::find($id);

        if (!$organizer) {
            return response()->json([
                "message" => "Organizer not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Success find organizer!",
            "data" => $organizer
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organizer = User::find($id);

        if (!$organizer) {
            return response()->json([
                "message" => "Organizer not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        $organizer->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => "organizer"
        ]);

        return response()->json([
            "message" => "Organizer updated!",
            "data" => $organizer
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organizer = User::find($id);

        if (!$organizer) {
            return response()->json([
                "message" => "Organizer not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        $organizer->delete();

        return response()->json([
            "message" => "Organizer deleted!",
        ], Response::HTTP_OK);
    }
}
