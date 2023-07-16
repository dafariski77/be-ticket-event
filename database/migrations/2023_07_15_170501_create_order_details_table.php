<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer("amount");
            $table->integer("price");
            $table->unsignedBigInteger("event_id")->nullable()->unsigned();
            $table->foreign("event_id")->references("id")->on("events")->cascadeOnDelete();
            $table->unsignedBigInteger("ticket_id")->nullable()->unsigned();
            $table->foreign("ticket_id")->references("id")->on("ticket_categories")->cascadeOnDelete();
            $table->unsignedBigInteger("order_id")->nullable()->unsigned();
            $table->foreign("order_id")->references("id")->on("orders")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
