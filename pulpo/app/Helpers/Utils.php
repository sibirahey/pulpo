<?php

namespace App\Helpers;

class Utils {

 public static function randUbicacion($limites) {
  // east: -99.14695412303467
  // north: 19.454208248638917
  // south: 19.41373798403144
  // west: -99.20900971080323
   $ubicacion = new \stdClass();
   $ubicacion->latitude = Utils::float_rand( floatval($limites->south), floatval($limites->north),6);
   $ubicacion->longitude = Utils::float_rand( floatval($limites->west), floatval($limites->east),6);
   return $ubicacion;
 }

 public static function float_rand($Min, $Max, $round=0){
    //validate input
    if ($Min > $Max) {
      $min=$Max; $max=$Min;
    }else {
      $min=$Min; $max=$Max;
    }
    $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    if($round > 0)
        $randomfloat = round($randomfloat,$round);

    return $randomfloat;
  }

}
