<?php

namespace App\Listeners;

use App\Events\PreventionAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Prevention;

class PreventionActionLog
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  PreventionAction  $event
     * @return void
     */
    public function handle(PreventionAction $event)
    {
        switch ($event->getAction()) {
            case 'created':
                $text = __('<b><i>:name</i></b> được tạo bởi :creator và giao cho :assignee', [
                        'name' => $event->getPrevention()->name,
                        'creator' => $event->getPrevention()->creator->name,
                        'assignee' => $event->getPrevention()->preventor->name
                    ]);
                break;
            case 'updated':
                $text = __('<b><i>:name</i></b> được sửa bởi :preventor', [
                    'name' => $event->getPrevention()->name,
                    'preventor' => $event->getPrevention()->preventor->name
                ]);
                break;
            case 'completed':
                $text = __('<b><i>:name</i></b> được hoàn thành bởi :preventor', [
                    'name' => $event->getPrevention()->name,
                    'preventor' => $event->getPrevention()->preventor->name
                ]);
                break;
            case 'updated_assign':
                $text = __('<b><i>:name</i></b> được chuyển từ :pre_preventor sang :preventor', [
                    'name' => $event->getPrevention()->name,
                    'pre_preventor' => $event->getPrevention()->pre_preventor->name,
                    'preventor' => $event->getPrevention()->preventor->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Prevention::class,
                'source_id' =>  $event->getPrevention()->ticket_id, //List all activity logs by Ticket
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
