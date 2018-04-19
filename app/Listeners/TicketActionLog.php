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
                        'assignee' => $event->getTicket()->director->name
                    ]);
                break;
            case 'updated_description':
                $text = __('<b><i>:title</i></b> được sửa đổi bởi :creator và giao cho :assignee', [
                    'title' => $event->getTicket()->title,
                    'creator' => $event->getTicket()->creator->name,
                    'assignee' => $event->getTicket()->director->name
                ]);
                break;
            case 'director_approved':
                $text = __('<b><i>:title</i></b> được <b style="color:blue">Đồng ý</b> bởi :director', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'director_rejected':
                $text = __('<b><i>:title</i></b> bị <b style="color:red">Từ chối</b> bởi :director', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'req_approve_root_cause':
                $text = __('<b><i>:title</i></b> :director yêu cầu :director duyệt nguyên nhân gốc rễ', [
                    'title' => $event->getTicket()->title,
                    'assigned_preventer' => $event->getTicket()->assigned_preventer->name,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'evaluated':
                $text = __('<b><i>:title</i></b> :director đã đánh giá sự không phù hợp là <b>:evaluation</b>', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'evaluation' => $event->getTicket()->evaluation->name,
                ]);
                break;
            case 'root_cause_approved':
                $text = __('<b><i>:title</i></b> nguyên nhân gốc rễ được <b style="color:blue">Đồng ý</b> bởi :director', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'root_cause_rejected':
                $text = __('<b><i>:title</i></b> nguyên nhân gốc rễ bị <b style="color:red">Từ chối</b> bởi :director', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'asset_effectiveness':
                $text = __('<b><i>:title</i></b> được đánh giá <b>:effectiveness</b> bởi :director', [
                    'title' => $event->getTicket()->title,
                    'effectiveness' => $event->getTicket()->effectiveness->name,
                    'director' => $event->getTicket()->director->name
                ]);
                break;
            case 'assigned_troubleshooter':
                $text = __('<b><i>:title</i></b> được :director giao cho :assigned_troubleshooter khắc phục', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_troubleshooter' => $event->getTicket()->assigned_troubleshooter->name,
                ]);
                break;
            case 'request_to_approve_troubleshoot':
                $text = __('<b><i>:title</i></b>, :assigned_troubleshooter yêu cầu :director phê duyệt biện pháp khắc phục', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_troubleshooter' => $event->getTicket()->assigned_troubleshooter->name,
                ]);
                break;
            case 'troubleshoot_approved':
                $text = __('<b><i>:title</i></b>, :director đã <b style="color:blue">Đồng ý</b> biện pháp khắc phục của :assigned_troubleshooter', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_troubleshooter' => $event->getTicket()->assigned_troubleshooter->name,
                ]);
                break;
            case 'troubleshoot_rejected':
                $text = __('<b><i>:title</i></b>, :director đã <b style="color:red">Từ chối</b> biện pháp khắc phục của :assigned_troubleshooter', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_troubleshooter' => $event->getTicket()->assigned_troubleshooter->name,
                ]);
                break;
            case 'assigned_preventer':
                $text = __('<b><i>:title</i></b> được :director giao cho :assigned_preventer đề xuất biện pháp phòng ngừa', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_preventer' => $event->getTicket()->assigned_preventer->name,
                ]);
                break;
            case 'request_to_approve_prevention':
                $text = __('<b><i>:title</i></b>, :assigned_preventer yêu cầu :director phê duyệt biện pháp phòng ngừa', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_preventer' => $event->getTicket()->assigned_preventer->name,
                ]);
                break;
            case 'prevention_approved':
                $text = __('<b><i>:title</i></b>, :director đã <b style="color:blue">Đồng ý</b> biện pháp phòng ngừa của :assigned_preventer', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_preventer' => $event->getTicket()->assigned_preventer->name,
                ]);
                break;
            case 'prevention_rejected':
                $text = __('<b><i>:title</i></b>, :director đã <b style="color:red">Từ chối</b> biện pháp phòng ngừa của :assigned_preventer', [
                    'title' => $event->getTicket()->title,
                    'director' => $event->getTicket()->director->name,
                    'assigned_preventer' => $event->getTicket()->assigned_preventer->name,
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
