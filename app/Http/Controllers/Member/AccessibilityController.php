<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\LogLoginInterface;
use App\Contracts\NotificationInterface;

class AccessibilityController extends Controller
{

    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var LogLoginInterface
     */
    private $log;

    /**
     * AccessibilityController constructor.
     * @param NotificationInterface $notification
     * @param LogLoginInterface $log
     */
    public function __construct(
        LogLoginInterface $log,
        NotificationInterface $notification

    )
    {
        $this->log = $log;
        $this->notification = $notification;

    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        $notifications = $this->notification->paginateByUserId(Auth::id(), 15);

        return response()
            ->view('member.accessibility.notification', compact('notifications'), 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function log()
    {
        $logs = $this->log->paginateByUserId(Auth::id(), 15);

        return response()
            ->view('member.accessibility.log', compact('logs'), 200);
    }
}
