<?php

namespace App\Console\Commands;

use App\Facades\OneSignal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OneSignalNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayumi:notification {template-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'OneSignalへの通知を行う';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $template_id = $this->argument('template-id');

        $response = OneSignal::sendNotificationFromTemplateToAll($template_id);
        if($response->getStatusCode() == 200) {
            $message = 'ID:'.$template_id.'の送信が成功しました。';
            Log::info($message);
        } else {
            $status = $response->getStatusCode();
            $errors = $response->getBody()->getContents();
            $message = 'ID:'.$template_id.'の送信が失敗しました。ステータスコード:'.$status.'メッセージ:'.$errors;
            Log::error($message);
        }
    }
}
