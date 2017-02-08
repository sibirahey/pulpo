<?php

namespace App\Helpers;

class Utils {

 public static function randUbicacion($northeast,$southwest) {
   $ubicacion = new \stdClass();
   $ubicacion->latitude = Utils::float_rand( floatval($southwest["latitude"]), floatval($northeast["latitude"]),6);
   $ubicacion->longitude = Utils::float_rand( floatval($southwest["longitude"]), floatval($northeast["longitude"]),6);
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
