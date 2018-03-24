<?php

namespace App\Listeners;

use App\Events\TroubleshootAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Troubleshoot;

class TroubleshootActionLog
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
     * @param  TroubleshootAction  $event
     * @return void
     */
    public function handle(TroubleshootAction $event)
    {
        switch ($event->getAction()) {
            case 'created':
                $text = __('<b><i>:name</i></b> được tạo bởi :creator và giao cho :assignee', [
                        'name' => $event->getTroubleshoot()->name,
                        'creator' => $event->getTroubleshoot()->creator->name,
                        'assignee' => $event->getTroubleshoot()->troubleshooter->name
                    ]);
                break;
            case 'updated':
                $text = __('<b><i>:name</i></b> được sửa bởi :troubleshooter', [
                    'name' => $event->getTroubleshoot()->name,
                    'troubleshooter' => $event->getTroubleshoot()->troubleshooter->name
                ]);
                break;
            case 'completed':
                $text = __('<b><i>:name</i></b> được hoàn thành bởi :troubleshooter', [
                    'name' => $event->getTroubleshoot()->name,
                    'troubleshooter' => $event->getTroubleshoot()->troubleshooter->name
                ]);
                break;
            case 'updated_assign':
                $text = __('<b><i>:name</i></b> được chuyển từ :pre_troubleshooter sang :troubleshooter', [
                    'name' => $event->getTroubleshoot()->name,
                    'pre_troubleshooter' => $event->getTroubleshoot()->pre_troubleshooter->name,
                    'troubleshooter' => $event->getTroubleshoot()->troubleshooter->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Troubleshoot::class,
                'source_id' =>  $event->getTroubleshoot()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
