<?php
namespace App\Repository\Notification;

use Illuminate\Http\Request;

interface NotificationRepositoryInterface
{
    public function index();

    public function countNotification();

    public function editNotificationSetting(Request $request);

    public function getNotificationSetting();


}
