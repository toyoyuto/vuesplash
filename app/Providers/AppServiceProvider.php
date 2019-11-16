<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->sqlLog();
        // $this->memoryLog();
        // Queue::before(function (JobProcessing $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->job->payload()
        //     \Log::debug('前');
        //     \Log::debug($event->job->payload());
        // });

        // Queue::after(function (JobProcessed $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->job->payload()
        //     \Log::debug('後');
        //     \Log::debug($event->job->payload());
        // });
        // Queue::failing(function (JobFailed $event) {
        //     \Log::debug('失敗した');
        // });
    }

    private function sqlLog()
    {
        \DB::listen(function ($query) {
            $sql = $query->sql;
            for ($i = 0; $i < count($query->bindings); $i++) {
                $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
            }

            \Log::debug("SQL", ["time" => sprintf("%.2f ms", $query->time), "sql" => $sql]);                                                                
        });
    }

    private function memoryLog()
    {
        \Log::debug(memory_get_peak_usage(true));
    }
}
