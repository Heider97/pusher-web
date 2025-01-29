<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfigAppChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('tms'),
        ];
    }

    public function broadcastWith()
    {
        return [
            "title" => "Nuevas Configuraciones detectadas",
            "body" => "Se han detectado nuevas configuraciones en el sistema, por favor revisarlas.",
            "config" => [
                "allow_insets_below" => 0,
                "mapbox" => "sk.eyJ1IjoiYmV4cGFuZGFwYW4yIiwiYSI6ImNsNWNuNHJmajBqNDMzamx3cGRkNnpxamsifQ.zxz8NkWhgOY9M1zfRKbztA",
                "created_at" => "2022-06-06 21:10:01",
                "updated_at" => "2022-09-16 01:45:09",
                "many_devices_users" => 1,
                "company" => "001",
                "mapbox_pk" => "pk.eyJ1IjoiYmV4cGFuZGFwYW4yIiwiYSI6ImNsNWI5aXBkdDA1ZmYzZHBnNnNhZ3hxZHAifQ.dca7sK2Zeq8EvoQyKil_eA",
                "request_mapbox" => 0,
                "had_take_picture" => 0,
                "can_block_clients" => 0,
                "required_arrived" => 0,
                "block_partial" => 0,
                "limit_days_works" => 2,
                "skip_update" => 1,
                "code_qr" => null,
                "can_make_history" => 1,
                "fixed_delivery_distance" => 0,
                "ratio" => 0,
                "had_reason_respawn" => 1,
                "allow_insets_above" => 0,
                "specified_account_transfer" => 0,
                "block_reject" => 0,
                "distance" => 50,
                "background_location" => 1,
                "time_to_callback" => 5,
                "multiple_accounts" => 0,
                "had_take_picture_transfer" => 0
            ]
        ];
    }
}
