<?php

namespace App\Notifications\Landing;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactFormSent extends Notification
{
    use Queueable;

    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new notification instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(
                __('Nuevo mensaje de: [:name]', [
                    'name' => $this->request->name,
                ])
            )
            ->greeting(
                __('Soy :name y este correo es por el siguiente asunto:', [
                    'name' => $this->request->name,
                ])
            )
            ->line(
                new HtmlString(
                    __('<div class="jumbotron"><p class="lead text-justify">:message</p></div>', [
                        'message' => $this->request->message,
                    ])
                )
            )
            ->line(
                __('Mi correo electrónico es: :email', [
                    'email' => $this->request->email,
                ])
            )
            ->salutation(
                __('Este mensaje fue enviado el: :at', [
                    'at' => now()->isoFormat('LL [a las] h:mm:ss'),
                ])
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
