<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Troubleshoot;

class TroubleshootActionNotification extends Notification
{
    use Queueable;


    private $troubleshoot;
    private $action;
    private $is_pre_troubleshooter;

    /**
     * Create a new notification instance.
     * TroubleshootActionNotification constructor.
     * @param $troubleshoot
     * @param $action
     * @param $is_pre_troubleshooter
     */
    public function __construct($troubleshoot, $action, $is_pre_troubleshooter)
    {
        $this->troubleshoot = $troubleshoot;
        $this->action = $action;
        $this->is_pre_troubleshooter = $is_pre_troubleshooter;
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
        $url = url('/tickets/'.$this->troubleshoot->id);
        $toName = '';
        switch ($this->action) {
            case 'created':
                $text = __(':name được tạo bởi :creator, và giao cho bạn', [
                    'name' =>  $this->troubleshoot->name,
                    'creator' => $this->troubleshoot->creator->name,
                ]);
                $toName = $this->troubleshoot->troubleshooter->name;
                break;
            case 'updated':
                $text = __(':name được sửa bởi :troubleshooter', [
                    'name' =>  $this->troubleshoot->name,
                    'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                ]);
                $toName = $this->troubleshoot->creator->name;
                break;
            case 'completed':
                $text = __(':name được hoàn thành bởi :troubleshooter', [
                    'name' =>  $this->troubleshoot->name,
                    'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                ]);
                $toName = $this->troubleshoot->creator->name;
                break;
            case 'updated_assign':
                if($this->is_pre_troubleshooter)
                {
                    $text = __(':name được chuyển từ bạn sang :troubleshooter', [
                        'name' =>  $this->troubleshoot->name,
                        'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                    ]);
                    $toName = $this->troubleshoot->pre_troubleshooter->name;
                } else {
                    $text = __(':name được chuyển từ :pre_troubleshooter cho bạn', [
                        'name' =>  $this->troubleshoot->name,
                        'pre_troubleshooter' => $this->troubleshoot->pre_troubleshooter->name,
                        'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                    ]);
                    $toName = $this->troubleshoot->troubleshooter->name;
                }
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
                $text = __(':name được tạo bởi :creator, và giao cho bạn', [
                    'name' =>  $this->troubleshoot->name,
                    'creator' => $this->troubleshoot->creator->name,
                    ]);
                $assigned_user = $this->troubleshoot->troubleshooter->name;
                $created_user = $this->troubleshoot->creator->name;
                break;
            case 'updated':
                $text = __(':name được sửa bởi :troubleshooter', [
                    'name' =>  $this->troubleshoot->name,
                    'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                ]);
                $assigned_user = $this->troubleshoot->troubleshooter->name;
                $created_user = $this->troubleshoot->creator->name;
                break;
            case 'completed':
                $text = __(':name được hoàn thành bởi :troubleshooter', [
                    'name' =>  $this->troubleshoot->name,
                    'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                ]);
                $assigned_user = $this->troubleshoot->troubleshooter->name;
                $created_user = $this->troubleshoot->creator->name;
                break;
            case 'updated_assign':
                if($this->is_pre_troubleshooter)
                {
                    $text = __(':name được chuyển từ bạn sang :troubleshooter', [
                        'name' =>  $this->troubleshoot->name,
                        'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                    ]);
                } else {
                    $text = __(':name được chuyển từ :pre_troubleshooter cho bạn', [
                        'name' =>  $this->troubleshoot->name,
                        'pre_troubleshooter' => $this->troubleshoot->pre_troubleshooter->name,
                        'troubleshooter' => $this->troubleshoot->troubleshooter->name,
                    ]);
                }
                $assigned_user = $this->troubleshoot->troubleshooter->name;
                $created_user = $this->troubleshoot->creator->name;
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $assigned_user, //Assigned user ID
            'created_user' => $created_user,
            'message' => $text,
            'type' =>  Troubleshoot::class,
            'type_id' =>  $this->troubleshoot->id,
            'url' => url('tickets/' . $this->troubleshoot->ticket_id),
            'action' => $this->action
        ];
    }
}
