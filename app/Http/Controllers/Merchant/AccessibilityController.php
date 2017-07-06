<?php

namespace App\Http\Controllers\Merchant;

use App\Contracts\LogLoginInterface;
use App\Contracts\NotificationInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        NotificationInterface $notification,
        LogLoginInterface $log
    )
    {
        $this->notification = $notification;
        $this->log = $log;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        $notifications = $this->notification->paginateByUserId(Auth::id(), 15);

        return response()
            ->view('merchant.accessibility-notification', compact('notifications'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function log_access()
    {
        $logs = $this->log->paginateByUserId(Auth::id(), 15);

        return response()
            ->view('merchant.accessibility-log-access', compact('logs'), 200);
    }
}
