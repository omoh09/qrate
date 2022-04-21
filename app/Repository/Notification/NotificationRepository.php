<?php


namespace App\Repository\Notification;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function index()
    {
        auth()->user()->unreadNotifications->map(function($n) {
            $n->markAsRead();
        });
        return auth()->user()->notifications()->orderBy('updated_at' ,'desc')->paginate(20);
    }
    public function countNotification()
    {
        return auth()->user()->unreadNotifications()->count() ;
    }

    public function editNotificationSetting(Request $request)
    {
        auth()->user()->update(
            [
                'notification_on' =>  $request->notification_on ? (bool) $request->notification_on : auth()->user()->notifitication_on,
                'post_notification' => $request->post_notification ? (bool) $request->post_notification: auth()->user()->post_notification,
            ]
            );
        return Helper::response('success','user notification setting updated',200);
    }
    public function getNotificationSetting()
    {
        $array = [
            'notification_on' => (bool) auth()->user()->notification_on,
            'post_notification' => (bool) auth()->user()->post_notification,
        ];

        return Helper::response('sucess','user notification settings' , 200, $array);
    }
}
