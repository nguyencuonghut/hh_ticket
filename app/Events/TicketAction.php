<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Ticket;

class TicketAction
{
    private $ticket;
    private $action;

    use InteractsWithSockets, SerializesModels;

    public function getTicket()
    {
        return $this->ticket;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a new event instance.
     * TaskAction constructor.
     * @param Ticket $ticket
     * @param $action
     */
    public function __construct(Ticket $ticket, $action)
    {
        $this->ticket = $ticket;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
