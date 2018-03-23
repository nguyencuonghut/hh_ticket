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
        $action = $event->getAction();switch ($event->getAction()) {
        case 'created':
        case 'updated_description':
            $ticket->managerUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'manager_approved':
        case 'manager_rejected':
            $ticket->creatorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        default:
            $ticket->creatorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
    }
    }
}
