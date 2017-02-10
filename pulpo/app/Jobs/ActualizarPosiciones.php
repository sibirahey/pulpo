<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

use App\Services\MarkerService;

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
    public function handle(MarkerService $markerService)
    {
      $markers = Redis::smembers('markers');
      foreach ($markers as $id) {
        sleep(1);//TODO: esperar en milisegundos
        $coords = json_decode(Redis::lpop($id));
        $mark = new \stdClass();
        $mark->key = $id;
        $mark->coords = $coords;
        if(Redis::llen($id) == 0){
          $destino = $markerService->nuevoPunto();
          $markerService->generarRuta($id,$coords,$destino);
        }
        Redis::publish('pulso', json_encode($mark));
      }

      $enServicio = Redis::smembers('enServicio');
      foreach ($enServicio as $element) {
        sleep(1);//TODO: esperar en milisegundos
        $coords = json_decode(Redis::lpop($element));
        $mark = new \stdClass();
        $mark->key = $element;
        $mark->coords = $coords;
        if(Redis::llen($element) == 0){
          Redis::srem('enServicio',$element);
          Redis::del($element);
          // Redis::publish('pulso', $element);
        }
        Redis::publish('pulso', json_encode($mark));
      }

      if(Redis::get('switch')=="start"){
        $job = new ActualizarPosiciones();
        dispatch($job);
      }
    }
}
