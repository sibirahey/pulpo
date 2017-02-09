<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

use App\Helpers\Utils;

class MarkerService
{
  public function guardar($northeast,$southwest)
  {
    $id = uniqid();
    $ubicacion = Utils::randUbicacion($northeast,$southwest);
    $destino = Utils::randUbicacion($northeast,$southwest);
    $this->generarRuta($id,$ubicacion,$destino);
    Redis::sadd('markers',$id);
    return $id;
  }

  public function generarRuta($id,$inicio,$fin)
  {
    $myURL = "http://www.yournavigation.org/api/1.0/gosmore.php?format=geojson"
    ."&flat=".$inicio->latitude
    ."&flon=".$inicio->longitude
    ."&tlat=".$fin->latitude
    ."&tlon=".$fin->longitude;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $myURL
    ));
    $resp = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($resp);
    // {latitude: "19.4346219", longitude: "-99.1796127"}
    foreach ($json->coordinates as $coor) {
      $ubicacion = new \stdClass();
      $ubicacion->latitude = $coor[1];
      $ubicacion->longitude = $coor[0];
      Redis::rpush($id,json_encode($ubicacion));
    }
  }
}
