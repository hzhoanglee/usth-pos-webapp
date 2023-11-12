<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
            $this->cart = session()->get('cart_'.$this->cart_id);
//            $this->message = json_encode($this->cart);
            $this->screen_id = $screen_id;
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
//            new PrivateChannel('cart_'.$this->cart_id),
            'screen_'. $this->screen_id
        ];
    }
}
