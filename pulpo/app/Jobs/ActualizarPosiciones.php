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
      while (Redis::get('switch')=="start") {
        $markers = Redis::smembers('markers');
        // $scard = Redis::scard('markers');
        // $esperar = 1000000 / $scard!=0?$scard:1;
        foreach ($markers as $id) {
          usleep(500000);
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

        $enServicio = Redis::hkeys('enServicio');
        // $hlen = Redis::hlen('enServicio');
        // $esperar = 1000000 / $hlen!=0?$hlen:1;
        foreach ($enServicio as $element) {
          usleep(500000);
          $coords = json_decode(Redis::lpop($element));
          $mark = new \stdClass();
          $mark->key = $element;
          $mark->coords = $coords;
          Redis::publish('pulso', json_encode($mark));
          if(Redis::llen($element) == 0){
            $fijo = Redis::hget('enServicio',$element);
            Redis::hdel('enServicio',$element);
            $eliminar= new \stdClass();
            $eliminar->inicio = $fijo;
            $eliminar->fin = $element;
            Redis::publish('delete', json_encode($eliminar));
          }
        }
      }

      // if(Redis::get('switch')=="start"){
      //   $job = new ActualizarPosiciones();
      //   dispatch($job);
      // }
    }
}
