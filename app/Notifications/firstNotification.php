<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class firstNotification extends Notification
{
    use Queueable;

   ///////////////ajouter le code suivant/////////////////
    private $detail;
    /**
     * Create a new notification instance.
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }
    /////////////////////////
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
 	/*return (new MailMessage)
            ->subject('Notification Laravel')
            ->greeting('Bonjour !')
            ->line('Ceci est un exemple de notification.')
            ->action('Voir', url('/'))
            ->line('Merci !');*/

           ////////////////modifier la fonction////////////////
        return (new MailMessage)
            ->greeting($this->detail["greeting"])
            ->line($this->detail["body"])
            ->action($this->detail["actiontext"], $this->detail["actionurl"])
            ->line($this->detail["lastline"]);

          //////////////////////////////////
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

