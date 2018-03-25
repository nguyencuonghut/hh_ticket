<?php

namespace App\Listeners;

use App\Events\TicketAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activity;
use Lang;
use App\Models\Ticket;

class TicketActionLog
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
     * @param  TicketAction  $event
     * @return void
     */
    public function handle(TicketAction $event)
    {
        switch ($event->getAction()) {
            case 'created':
                $text = __('<b><i>:title</i></b> được tạo bởi :creator và giao cho :assignee', [
                        'title' => $event->getTicket()->title,
                        'creator' => $event->getTicket()->creator->name,
                        'assignee' => $event->getTicket()->manager->name
                    ]);
                break;
            case 'updated_description':
                $text = __('<b><i>:title</i></b> được sửa đổi bởi :creator và giao cho :assignee', [
                    'title' => $event->getTicket()->title,
                    'creator' => $event->getTicket()->creator->name,
                    'assignee' => $event->getTicket()->manager->name
                ]);
                break;
            case 'manager_approved':
                $text = __('<b><i>:title</i></b> được đồng ý bởi :manager', [
                    'title' => $event->getTicket()->title,
                    'manager' => $event->getTicket()->manager->name
                ]);
                break;
            case 'manager_rejected':
                $text = __('<b><i>:title</i></b> bị từ chối bởi :manager', [
                    'title' => $event->getTicket()->title,
                    'manager' => $event->getTicket()->manager->name
                ]);
                break;
            case 'req_approve_root_cause':
                $text = __('<b><i>:title</i></b> :manager yêu cầu :root_cause_approver duyệt nguyên nhân gốc rễ', [
                    'title' => $event->getTicket()->title,
                    'manager' => $event->getTicket()->manager->name,
                    'root_cause_approver' => $event->getTicket()->root_cause_approver->name
                ]);
                break;
            case 'root_cause_approved':
                $text = __('<b><i>:title</i></b> nguyên nhân gốc rễ được đồng ý bởi :root_cause_approver', [
                    'title' => $event->getTicket()->title,
                    'root_cause_approver' => $event->getTicket()->root_cause_approver->name
                ]);
                break;
            case 'root_cause_rejected':
                $text = __('<b><i>:title</i></b> nguyên nhân gốc rễ bị từ chối bởi :root_cause_approver', [
                    'title' => $event->getTicket()->title,
                    'root_cause_approver' => $event->getTicket()->root_cause_approver->name
                ]);
                break;
            default:
                break;
        }

        $activityinput = array_merge(
            [
                'text' => $text,
                'user_id' => Auth()->id(),
                'source_type' =>  Ticket::class,
                'source_id' =>  $event->getTicket()->id,
                'action' => $event->getAction()
            ]
        );
        
        Activity::create($activityinput);
    }
}
