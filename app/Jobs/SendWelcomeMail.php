<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Mail\ErrorJob;
use Log;

class SendWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(env('TOYO_MAIL_FROM_ADDRESS'))->queue((new OrderShipped())->onQueue('emails'));
    }

    /**
     * 失敗したジョブの処理
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed()
    {
        Log::info('erorrr!!!!!!!!!!!!!!!!');
        // 失敗の通知をユーザーへ送るなど…
        Mail::to(env('TOYO_MAIL_FROM_ADDRESS'))->queue((new ErrorJob())->onQueue('error'));
    }
}
