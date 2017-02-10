<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

use App\Helpers\Utils;

class MarkerService
{
  public function guardar()
  {
    $id = uniqid();
    $ubicacion = $this->nuevoPunto();
    $destino = $this->nuevoPunto();
    $this->generarRuta($id,$ubicacion,$destino);
    Redis::sadd('markers',$id);
    return $id;
  }

  public function nuevoPunto()
  {
    $bounds = json_decode(Redis::get('bounds'));
    return Utils::randUbicacion($bounds);
  }

  public function solicitarServicio($id)
  {
    $cercano = $this->buscarMarkerCercano($id);
    if($cercano == NULL){
      return NULL;
    }
    Redis::srem('markers',$id);
    Redis::srem('markers',$cercano);
    $coordsFin = $this->eliminar($id);
    $coordsInicio = $this->eliminar($cercano);
    $pasos = $this->generarRuta($cercano,$coordsInicio,$coordsFin);
    // $enServicio= new \stdClass();
    // $enServicio->idFin = $id;
    // $enServicio->id = $cercano;
    // Redis::sadd('enServicio',json_encode($enServicio));
    Redis::hset('enServicio',$cercano,$id);
    $ruta= new \stdClass();
    $ruta->id = $cercano;
    $ruta->ruta = $pasos;
    return json_encode($ruta);
  }

  public function eliminar($id){
    Redis::srem('markers',$id);
    $coords = json_decode(Redis::lindex($id,0));
    Redis::del($id);
    return $coords;
  }

  public function buscarMarkerCercano($id)
  {
    $coordsPrincipal = json_decode(Redis::lindex($id,0));
    $markers = Redis::smembers('markers');
    $distancia = 100000;
    $cercano = NULL;
    foreach ($markers as $markId) {
      if($markId == $id){
        continue;
      }
      $coords = json_decode(Redis::lindex($markId,0));
      $dist = Utils::distancia($coordsPrincipal,$coords);
      if($dist != NULL && $dist < $distancia){
        $cercano = $markId;
        $distancia = $dist;
      }
    }
    return $cercano;
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
    $ruta = array();
    foreach ($json->coordinates as $coor) {
      $ubicacion = new \stdClass();
      $ubicacion->latitude = $coor[1];
      $ubicacion->longitude = $coor[0];
      Redis::rpush($id,json_encode($ubicacion));
      array_push($ruta, $ubicacion);
    }
    return $ruta;
  }
}
