<?php

namespace App\Listeners;

use App\Events\TicketAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\TicketActionNotification;

class TicketActionNotify
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketAction  $event
     * @return void
     */
    public function handle(TicketAction $event)
    {
        $ticket = $event->getTicket();
        $action = $event->getAction();
        $ticket->assignedUser->notify(new TicketActionNotification(
            $ticket,
            $action
        ));
    }
}
