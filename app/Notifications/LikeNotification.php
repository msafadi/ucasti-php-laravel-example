<?php

namespace App\Notifications;

use App\Channels\MyNexmoChannel;
use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class LikeNotification extends Notification
{
    use Queueable;

    protected $post;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        //
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', MyNexmoChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hi ' . $notifiable->name)
                    ->line(sprintf('%s Liked your post "%s"', $this->user->name, $this->post->content))
                    ->action('Go to Post', route('timeline'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'icon' => 'like',
            'url' => route('timeline'),
            'post_id' => $this->post->id,
            'message' => sprintf('%s Liked your post "%s"', $this->user->name, $this->post->content),
        ];
    }

    public function toNexmo($notifiable)
    {
        $message = new NexmoMessage();
        $message->content(sprintf('%s Liked your post', $this->user->name));

        return $message;
    }

    public function toMyNexmo($notifiable)
    {
        return sprintf('%s Liked your post', $this->user->name);
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
