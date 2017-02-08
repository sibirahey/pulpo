<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class ActualizarPosiciones implements ShouldQueue
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
      $markers = Redis::smembers('markers');
      foreach ($markers as $mark) {
        sleep(10);
        //pop de lista -actualzar posiciones
        Redis::publish('pulso', Redis::get($mark));
      }
      if(Redis::get('switch')=="false"){
        $job = new ActualizarPosiciones();
        dispatch($job);
      }
    }
}
