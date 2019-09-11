<?php

namespace App\Channels;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class MyNexmoChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMyNexmo($notifiable);

        $client = new Client();
        $res = $client->request('POST', 'https://rest.nexmo.com/sms/json', [
                'form_params' => [
                    'api_key' => config('services.nexmo.key'),
                    'api_secret' => config('services.nexmo.secret'),
                    'to' => $notifiable->routeNotificationForNexmo(),
                    'from' => config('services.nexmo.sms_from'),
                    'text' => $message,
                ]
        ]);

        echo $res->getBody();
        
    }
}
