<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('category')->with("ticket_category")->get();

        return response()->json([
            "message" => "Success get all events data!",
            "data" => $events
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = $request->validated();

        if ($request->hasFile('image')) {
            $filePath = Storage::disk('public')->put('images', request()->file('image'));
            $event['image'] = $filePath;
        }

        $createEvent = Event::create($event);

        return response()->json([
            "message" => "Event created!",
            "data" => $createEvent
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with('category')->find($id);

        if (!$event) {
            return response()->json([
                "message" => "Event not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Success find event!",
            "data" => $event
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, string $id)
    {
        $find = Event::find($id);

        if (!$find) {
            return response()->json([
                "message" => "Event not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        $event = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($find->image);

            $filePath  = Storage::disk('public')->put('images', request()->file('image'));
            $event['image'] = $filePath;
        }

        $update = $find->update($event);

        return response()->json([
            "message" => "Event updated!",
            "data" => $update
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                "message" => "Event not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        Storage::disk('public')->delete($event->image);

        $event->delete($id);

        return response()->json([
            "message" => "Event deleted!",
            "data" => $event
        ], Response::HTTP_OK);
    }
}
