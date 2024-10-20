<?php

namespace App\Services;

use GuzzleHttp\Client;

class OneSignalService
{
   public function __construct()
   {

   }

   public function sendNotification(array $contents, array $segments)
   {
        $endpoint = 'https://api.onesignal.com/notifications';
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic '.config('onesignal.rest_api_key'),
            ],
            'json' => [
                'app_id' => config('onesignal.app_id'),
                'target_channel' => 'push',
                'contents' => $contents,
                'included_segments' => $segments,
            ],
        ];

        $client = new Client();

        return $client->request('POST', $endpoint, $options);
   }

   public function sendNotificationFromTemplate(string $template_id, array $segments)
   {
        $endpoint = 'https://api.onesignal.com/notifications';
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic '.config('onesignal.rest_api_key'),
            ],
            'json' => [
                'app_id' => config('onesignal.app_id'),
                'target_channel' => 'push',
                'template_id' => $template_id,
                'included_segments' => $segments,
            ],
        ];

        $client = new Client();

        return $client->request('POST', $endpoint, $options);
   }

   public function sendNotificationToAll(string|array $content)
   {
        $content = [
            'en' => $content,
        ];
        $segments = [
            'Total Subscriptions',
        ];

        return $this->sendNotification($content, $segments);
   }

   public function sendNotificationFromTemplateToAll(string $template_id)
   {
        $segments = [
            'Total Subscriptions',
        ];

        return $this->sendNotificationFromTemplate($template_id, $segments);
   }
}
