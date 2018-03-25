<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lang;
use App\Models\Prevention;

class PreventionActionNotification extends Notification
{
    use Queueable;


    private $prevention;
    private $action;
    private $is_pre_preventor;

    /**
     * Create a new notification instance.
     * PreventionActionNotification constructor.
     * @param $troubleshoot
     * @param $action
     * @param $is_pre_troubleshooter
     */
    public function __construct($prevention, $action, $is_pre_preventor)
    {
        $this->prevention = $prevention;
        $this->action = $action;
        $this->is_pre_preventor = $is_pre_preventor;
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
        $url = url('/tickets/'.$this->prevention->id);
        $toName = '';
        switch ($this->action) {
            case 'created':
                $text = __(':name được tạo bởi :creator, và giao cho bạn', [
                    'name' =>  $this->prevention->name,
                    'creator' => $this->prevention->creator->name,
                ]);
                $toName = $this->prevention->preventor->name;
                break;
            case 'updated':
                $text = __(':name được sửa bởi :preventor', [
                    'name' =>  $this->prevention->name,
                    'preventor' => $this->prevention->preventor->name,
                ]);
                $toName = $this->prevention->creator->name;
                break;
            case 'completed':
                $text = __(':name được hoàn thành bởi :preventor', [
                    'name' =>  $this->prevention->name,
                    'preventor' => $this->prevention->preventor->name,
                ]);
                $toName = $this->prevention->creator->name;
                break;
            case 'updated_assign':
                if($this->is_pre_preventor)
                {
                    $text = __(':name được chuyển từ bạn sang :preventor', [
                        'name' =>  $this->prevention->name,
                        'preventor' => $this->prevention->preventor->name,
                    ]);
                    $toName = $this->prevention->pre_preventor->name;
                } else {
                    $text = __(':name được chuyển từ :pre_troubleshooter cho bạn', [
                        'name' =>  $this->prevention->name,
                        'pre_preventor' => $this->prevention->pre_preventor->name,
                        'preventor' => $this->prevention->preventor->name,
                    ]);
                    $toName = $this->prevention->preventor->name;
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
                    'name' =>  $this->prevention->name,
                    'creator' => $this->prevention->creator->name,
                    ]);
                $assigned_user = $this->prevention->preventor->name;
                $created_user = $this->prevention->creator->name;
                break;
            case 'updated':
                $text = __(':name được sửa bởi :preventor', [
                    'name' =>  $this->prevention->name,
                    'preventor' => $this->prevention->preventor->name,
                ]);
                $assigned_user = $this->prevention->preventor->name;
                $created_user = $this->prevention->creator->name;
                break;
            case 'completed':
                $text = __(':name được hoàn thành bởi :preventor', [
                    'name' =>  $this->prevention->name,
                    'preventor' => $this->prevention->preventor->name,
                ]);
                $assigned_user = $this->prevention->preventor->name;
                $created_user = $this->prevention->creator->name;
                break;
            case 'updated_assign':
                if($this->is_pre_preventor)
                {
                    $text = __(':name được chuyển từ bạn sang :preventor', [
                        'name' =>  $this->prevention->name,
                        'preventor' => $this->prevention->preventor->name,
                    ]);
                } else {
                    $text = __(':name được chuyển từ :pre_preventor cho bạn', [
                        'name' =>  $this->prevention->name,
                        'pre_preventor' => $this->prevention->pre_preventor->name,
                        'preventor' => $this->prevention->preventor->name,
                    ]);
                }
                $assigned_user = $this->prevention->preventor->name;
                $created_user = $this->prevention->creator->name;
                break;
            default:
                break;
        }
        return [
            'assigned_user' => $assigned_user, //Assigned user ID
            'created_user' => $created_user,
            'message' => $text,
            'type' =>  Prevention::class,
            'type_id' =>  $this->prevention->id,
            'url' => url('tickets/' . $this->prevention->ticket_id),
            'action' => $this->action
        ];
    }
}
