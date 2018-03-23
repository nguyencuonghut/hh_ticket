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
                $toName = $this->ticket->manager->name;
                break;
            case 'updated_description':
                $text = __(':title được sửa đổi bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                ]);
                $toName = $this->ticket->manager->name;
                break;
            case 'manager_approved':
                $text = __(':title được xác nhận bởi :manager', [
                    'title' =>  $this->ticket->title,
                    'manager' => $this->ticket->manager->name,
                ]);
                $toName = $this->ticket->creator->name;
                break;
            case 'manager_rejected':
                $text = __(':title bị từ chối xác nhận bởi :manager', [
                    'title' =>  $this->ticket->title,
                    'manager' => $this->ticket->manager->name,
                ]);
                $toName = $this->ticket->creator->name;
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
                $assigned_user = $this->ticket->manager->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'updated_description':
                $text = __(':title được sửa đổi bởi :creator, và giao cho bạn', [
                    'title' =>  $this->ticket->title,
                    'creator' => $this->ticket->creator->name,
                ]);
                $assigned_user = $this->ticket->manager->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'manager_approved':
                $text = __(':title được đồng ý bởi :manager', [
                    'title' =>  $this->ticket->title,
                    'manager' => $this->ticket->manager->name,
                ]);
                $assigned_user = $this->ticket->manager->name;
                $created_user =$this->ticket->creator->name;
                break;
            case 'manager_rejected':
                $text = __(':title bị từ chối bởi :manager', [
                    'title' =>  $this->ticket->title,
                    'manager' => $this->ticket->manager->name,
                ]);
                $assigned_user = $this->ticket->manager->name;
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
