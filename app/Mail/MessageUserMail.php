<?php

namespace App\Mail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Expr\Cast\String_;
use App\Models\User;

class MessageUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /** 
     *
     * @var App\Models\Email $email
     */
    public $email;

     /** 
     *
     * 
     * @var App\Models\User $user
     */
    public $user;


    /**
     * Create a new Mailable instance.
     *
     * @return void
     */
    public function __construct(Email $email, User $user)
    {
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */ 
    public function build()
    {
        $data = [
            $this->user,
            $this->email
        ];
        
        return $this->view('dashboard.users.message')->with($data)
        ->subject($this->email->subject)
        ->priority(1);
    }
}
