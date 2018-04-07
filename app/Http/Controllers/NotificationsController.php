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
        $action = $user->notifications->where('id', $request->id)->first()->data['action'];
        switch ($type) {
            case 'App\Notifications\TicketActionNotification':
                $tab = 'description';
                if('asset_effectiveness' == $action
                    || 'root_cause_approved' == $action
                    || 'root_cause_rejected' == $action
                    || 'req_approve_root_cause' == $action
                    || 'assigned_preventer' == $action
                    || 'request_to_approve_prevention' == $action
                    || 'prevention_approved' == $action
                    || 'prevention_rejected' == $action)
                {
                    $tab = 'prevention';
                } elseif ('assigned_troubleshooter' == $action
                    || 'request_to_approve_troubleshoot' == $action)
                {
                    $tab = 'troubleshoot';
                }
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
