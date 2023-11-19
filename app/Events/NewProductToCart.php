<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class NewProductToCart implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public mixed $cart;
    public int $cart_id;
    public int $screen_id;
//    public string $message;
    public function __construct($cart_id, $screen_id)
    {
        try {
            $this->cart_id = $cart_id;
            $this->cart = Cache::get('cart_'.$this->cart_id);
            $this->screen_id = $screen_id;
            Cache::put('screen_'.$this->screen_id, $this->cart, 60*24*7);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
//            new PrivateChannel('pos_auth_'.auth()->id()),
            'screen_'. $this->screen_id
        ];
    }
}
