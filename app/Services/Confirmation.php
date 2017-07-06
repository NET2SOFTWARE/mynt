<?php

namespace App\Services;

use App\Mail\EmailConfirmation;
use App\User;
use Illuminate\Support\Facades\Mail;

class Confirmation
{
    /**
     * @var
     */
    protected $mailer;

    /**
     * @var \App\Services\ConfirmationRepository
     */
    protected $confirmation;

    /**
     * @var int
     */
    protected $resendAfter = 24;

    /**
     * @var
     */
    protected $userService;

    /**
     * Confirmation constructor.
     * @param \App\Services\ConfirmationRepository $confirmation
     * @param \App\Services\UserService $userService
     */
    public function __construct(
        ConfirmationRepository $confirmation,
        UserService $userService
    )
    {
        $this->confirmation = $confirmation;
        $this->userService = $userService;
    }

    /**
     * @param $user
     */
    public function sendConfirmationMail($user)
    {
        if ($this->confirmation->userMustConfirmed($user) || !$this->shouldSend($user))
            return;

        Mail::to($user->email)
            ->send(new EmailConfirmation($user, $this->confirmation->createConfirmation($user)));
    }

    /**
     * @param $token
     * @return null
     */
    public function confirmUser($token)
    {
        $confirmation = $this->confirmation->getConfirmationByToken($token);

        if ($confirmation === null)
            return null;

        $user = User::find($confirmation->user_id);

        $this
            ->confirmation
            ->deleteConfirmation($token);

        $user->update([
            'isConfirmed' => (boolean) true
        ]);

        return $user;
    }

    /**
     * @param $user
     * @return bool
     */
    private function shouldSend($user)
    {
        $confirmation = $this->confirmation->getConfirmation($user);

        return $confirmation === null || strtotime($confirmation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}