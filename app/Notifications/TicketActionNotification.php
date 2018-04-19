<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Ticket;

class TicketActionNotification extends Notification
{
    use Queueable;


    private $ticket;
    private $action;

    /**
     * Create a new notification instance.
     * TaskActionNotification constructor.
     * @param $task
     * @param $action
     */
    public function __construct($ticket, $action)
    {
        $this->ticket = $ticket;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/tickets/'.$this->ticket->id);
        $toName = '';
        switch ($this->action) {
            case 'created':
                $text = __(':title được tạo bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'updated_description':
                $text = __(':title được sửa đổi bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'director_approved':
                $text = __(':title được xác nhận bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->creator->name;
                break;
            case 'director_rejected':
                $text = __(':title bị từ chối xác nhận bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->creator->name;
                break;
            case 'evaluated':
                $text = __(':title, :director đã đánh giá là :evaluation', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                    'evaluation' => $this->ticket->evaluation->name,
                ]);
                $toName = $this->ticket->creator->name;
                break;
            case 'req_approve_root_cause':
                $text = __(':title yêu cầu bạn duyệt nguyên nhân gốc rễ', [
                    'title' =>  $this->ticket->title,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'root_cause_approved':
                $text = __(':title nguyên nhân gốc rễ được đồng ý bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'root_cause_rejected':
                $text = __(':title nguyên nhân gốc rễ bị từ chối bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'asset_effectiveness':
                $text = __(':title được đánh giá :effectiveness :director', [
                    'title' =>  $this->ticket->title,
                    'effectiveness' => $this->ticket->effectiveness->name,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_preventer->name;
                break;
            case 'assigned_troubleshooter':
                $text = __(':title được :director giao cho bạn khắc phục', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_troubleshooter->name;
                break;
            case 'request_to_approve_troubleshoot':
                $text = __(':title, :assigned_troubleshooter đề nghị bạn duyệt biện pháp khắc phục', [
                    'title' =>  $this->ticket->title,
                    'assigned_troubleshooter' => $this->ticket->assigned_troubleshooter->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'troubleshoot_approved':
                $text = __(':title, :director đã đồng ý biện pháp khắc phục của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_troubleshooter->name;
                break;
            case 'troubleshoot_rejected':
                $text = __(':title, :director đã từ chối biện pháp khắc phục của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_troubleshooter->name;
                break;
            case 'assigned_preventer':
                $text = __(':title được :director giao cho bạn đề xuất biện pháp phòng ngừa', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_preventer->name;
                break;
            case 'request_to_approve_prevention':
                $text = __(':title, :assigned_preventer đề nghị bạn duyệt biện pháp phòng ngừa', [
                    'title' =>  $this->ticket->title,
                    'assigned_preventer' => $this->ticket->assigned_preventer->name,
                ]);
                $toName = $this->ticket->director->name;
                break;
            case 'prevention_approved':
                $text = __(':title, :director đã đồng ý biện pháp phòng ngừa của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_preventer->name;
                break;
            case 'prevention_rejected':
                $text = __(':title, :director đã từ chối biện pháp phòng ngừa của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $toName = $this->ticket->assigned_preventer->name;
                break;
            default:
                break;
        }
        return (new MailMessage)
            ->subject('Thông báo phiếu C.A.R')
            ->action('Thông báo', $url)
            ->line($toName)
            ->line($text);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        switch ($this->action) {
            case 'created':
                $text = __(':title được tạo bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                    ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'updated_description':
                $text = __(':title được sửa đổi bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'director_approved':
                $text = __(':title được đồng ý bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'director_rejected':
                $text = __(':title bị từ chối bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'req_approve_root_cause':
                $text = __(':title, :assigned_preventer yêu cầu bạn duyệt nguyên nhân gốc rễ', [
                    'title' =>  $this->ticket->title,
                    'assigned_preventer' => $this->ticket->assigned_preventer->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'evaluated':
                $text = __(':title, :director đã đánh giá sự không phù hợp là :evaluation', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                    'evaluation' => $this->ticket->evaluation->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'root_cause_approved':
                $text = __(':title nguyên nhân gốc rễ được đồng ý bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'root_cause_rejected':
                $text = __(':title nguyên nhân gốc rễ bị từ chối bởi :director', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'asset_effectiveness':
                $text = __(':title được đánh giá :effectiveness bởi :director', [
                    'title' =>  $this->ticket->title,
                    'effectiveness' => $this->ticket->effectiveness->name,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'assigned_troubleshooter':
                $text = __(':title được :director giao cho bạn khắc phục', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'request_to_approve_troubleshoot':
                $text = __(':title, :assigned_troubleshooter đề nghị bạn duyệt biện pháp khắc phục', [
                    'title' =>  $this->ticket->title,
                    'assigned_troubleshooter' => $this->ticket->assigned_troubleshooter->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'troubleshoot_approved':
                $text = __(':title, :director đã đồng ý biện pháp khắc phục của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'troubleshoot_rejected':
                $text = __(':title, :director đã từ chối biện pháp khắc phục của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'assigned_preventer':
                $text = __(':title được :director giao cho bạn đề xuất biện pháp phòng ngừa', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;

            case 'request_to_approve_prevention':
                $text = __(':title, :assigned_preventer đề nghị bạn duyệt biện pháp phòng ngừa', [
                    'title' =>  $this->ticket->title,
                    'assigned_preventer' => $this->ticket->assigned_preventer->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'prevention_approved':
                $text = __(':title, :director đã đồng ý biện pháp phòng ngừa của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'prevention_rejected':
                $text = __(':title, :director đã từ chối biện pháp phòng ngừa của bạn', [
                    'title' =>  $this->ticket->title,
                    'director' => $this->ticket->director->name,
                ]);
                $assigned_user = $this->ticket->director->name;
                $created_user =$this->ticket->creator->name;
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $assigned_user, //Assigned user ID
            'created_user' => $created_user,
            'message' => $text,
            'type' =>  Ticket::class,
            'type_id' =>  $this->ticket->id,
            'url' => url('tickets/' . $this->ticket->id),
            'action' => $this->action
        ];
    }
}
