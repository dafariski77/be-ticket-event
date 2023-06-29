<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketCategoryRequest;
use App\Http\Requests\UpdateTicketCategoryRequest;
use App\Models\TicketCategory;
use Illuminate\Http\Response;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = TicketCategory::all();

        return response()->json([
            "message" => "Success get all tickets data!",
            "data" => $tickets
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketCategoryRequest $request)
    {
        $ticket = $request->validated();

        $createTicket = TicketCategory::create($ticket);

        return response()->json([
            "message" => "Ticket created!",
            "data" => $createTicket
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = TicketCategory::find($id);

        if (!$ticket) {
            return response()->json([
                "message" => "Ticket category not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Success find ticket!",
            "data" => $ticket
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketCategoryRequest $request, string $id)
    {
        $find = TicketCategory::find($id);

        if (!$find) {
            return response()->json([
                "message" => "Ticket not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        $ticket = $request->validated();

        $update = $find->update($ticket);

        return response()->json([
            "message" => "Ticket updated!",
            "data" => $update
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = TicketCategory::find($id);

        if (!$ticket) {
            return response()->json([
                "message" => "Ticket not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        $ticket->delete($id);

        return response()->json([
            "message" => "Ticket deleted!",
            "data" => $ticket
        ], Response::HTTP_OK);
    }

    public function getByEventId(string $id) {
        $tickets = TicketCategory::where("event_id", $id)->get();

        return response()->json([
            "message" => "Success get tickets!",
            "data" => $tickets
        ], Response::HTTP_OK);
    }
}
