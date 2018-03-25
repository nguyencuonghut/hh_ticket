<?php

namespace App\Listeners;

use App\Events\PreventionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\PreventionActionNotification;

class PreventionActionNotify
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
     * @param  PreventionAction  $event
     * @return void
     */
    public function handle(PreventionAction $event)
    {
        $prevention = $event->getPrevention();
        $action = $event->getAction();switch ($event->getAction()) {
        case 'created':
            $prevention->preventorUser->notify(new PreventionActionNotification(
                $prevention,
                $action,
                false
            ));
            break;
        case 'updated':
        case 'completed':
            $prevention->creatorUser->notify(new PreventionActionNotification(
                $prevention,
                $action,
                false
            ));
            break;
        case 'updated_assign':
            $prevention->preventorUser->notify(new PreventionActionNotification(
                $prevention,
                $action,
                false
            ));
            $prevention->prePreventorUser->notify(new PreventionActionNotification(
                $prevention,
                $action,
                true
            ));
            break;
        default:
            $prevention->preventorUser->notify(new TroubleshootActionNotification(
                $prevention,
                $action,
                false
            ));
            break;
    }
    }
}
