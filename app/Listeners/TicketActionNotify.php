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
            $ticket->directorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'director_approved':
        case 'director_rejected':
            $ticket->creatorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'req_approve_root_cause':
            $ticket->directorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'root_cause_approved':
        case 'root_cause_rejected':
        case 'asset_effectiveness':
            $ticket->assignedPreventerUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'request_to_approve_troubleshoot':
            $ticket->directorUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'assigned_troubleshooter':
        case 'troubleshoot_approved':
        case 'troubleshoot_rejected':
            $ticket->assignedTroubleshooterUser->notify(new TicketActionNotification(
                $ticket,
                $action
            ));
            break;
        case 'assigned_preventer':
            $ticket->assignedPreventerUser->notify(new TicketActionNotification(
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
