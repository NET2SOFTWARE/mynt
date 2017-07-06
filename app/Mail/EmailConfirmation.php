<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class EmailConfirmation
 * @package App\Mail
 */
class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $token;

    /**
     * Create a new message instance.
     * @param \App\User $user
     * @param $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email.confirmation')
                        ->with('user', $this->user)
                        ->with('token', $this->token);
    }
}
