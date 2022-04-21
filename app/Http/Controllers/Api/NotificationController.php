<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Repository\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * @var NotificationRepositoryInterface
     */
    private $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return Helper::response('success','user notification', 200, NotificationResource::collection($this->repository->index()));
    }

    public function counts()
    {
        return Helper::response('success','user notification count', 200, ['count' => $this->repository->countNotification()]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate(
            [
                'notification_on' => 'required|boolean',
                'post_notification' => 'required|boolean'
            ]
        );
        return $this->repository->editNotificationSetting($request);
    }

    public function getNotificationSettings()
    {
        return $this->repository->getNotificationSetting();
    }
}
