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
      sleep(10);
      $num = Redis::get('num');
      Redis::set('num',$num + 1);
      //ver nuevos vehiculos
      //actualzar posiciones
        //verificar Pausa si pausa enviar a cola de pausa
        if(Redis::get('switch')=="false"){
          $job = new ActualizarPosiciones();
          //$job->delay(Carbon::now()->addSeconds(100));
          dispatch($job);
        }
    }
}
