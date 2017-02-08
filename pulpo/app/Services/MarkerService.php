<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class MarkerService
{
  public function guardar($ubicacion)
  {
    $id = uniqid();
    //TODO:consultar y guardar ruta list de redis
    Redis::set($id,json_encode($ubicacion));
    Redis::sadd('markers',$id);
    return $id;
  }
}
