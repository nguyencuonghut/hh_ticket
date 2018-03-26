<?php
namespace App\Http\Controllers;

use Notifynder;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;

class NotificationsController extends Controller
{
    /**
     * Mark a notification read
     * @param Request $request
     * @return mixed
     */
    public function markRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications()->where('id', $request->id)->first()->markAsRead();

        $type = $user->notifications->where('id', $request->id)->first()->type;
        switch ($type) {
            case 'App\Notifications\TicketActionNotification':
                $tab = 'description';
                break;
            case 'App\Notifications\TroubleshootActionNotification':
                $tab = 'troubleshoot';
                break;
            case 'App\Notifications\PreventionActionNotification':
                $tab = 'prevention';
                break;
            default:
                $tab = 'prevention';
                break;
        }
        return redirect($user->notifications->where('id', $request->id)->first()->data['url'])->with('tab', $tab);
    }

    /**
     * Mark all notifications as read
     * @return mixed
     */
    public function markAll()
    {
        $user = User::find(\Auth::id());
    
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }
}
