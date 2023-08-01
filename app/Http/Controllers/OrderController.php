<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Models\OrderDetail;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('order_detail', 'user')->with('order_detail.ticket')->with('order_detail.event')->get();

        return response()->json([
            "message" => "Success get All Orders!",
            "data" => $orders
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $request->validated();

        $user_id = auth()->user()->id;

        $store_order = Order::create([
            "total" => $order['total'],
            "user_id" => $user_id
        ]);

        foreach ($order['detail'] as $detail) {
            OrderDetail::create([
                'amount' => $detail['amount'],
                'price' => $detail['price'],
                'order_id' => $store_order->id,
                'event_id' => $detail['event_id'],
                'ticket_id' => $detail['ticket_id']
            ]);
        }

        return response()->json([
            "message" => "Order success",
            "data" => $order,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::where('user_id', $id)->with('order_detail', 'user')->with('order_detail.ticket')->with('order_detail.event')->latest('created_at')->get();

        if (!$order) {
            return response()->json([
                "message" => "Order data not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Success get Order data!",
            "data" => $order
        ], Response::HTTP_OK);
    }
}
