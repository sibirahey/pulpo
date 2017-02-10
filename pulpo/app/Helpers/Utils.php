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

//http://www.movable-type.co.uk/scripts/latlong.html
 public static function distancia($uno,$dos){
   if($uno == NULL || $dos == NULL){
     return NULL;
   }
   $lon1 = deg2rad($uno->longitude);
   $lat1 = deg2rad($uno->latitude);
   $lon2 = deg2rad($dos->longitude);
   $lat2 = deg2rad($dos->latitude);
   $R = 6371000;
   $dlon = $lon2 - $lon1;
   $dlat = $lat2 - $lat1;
   $a = pow(sin($dlat/2),2) + cos($lat1) * cos($lat2) * pow(sin($dlon/2),2);
   $c = 2 * atan2( sqrt($a), sqrt(1-$a) );
   $d = $R * $c; //(where R is the radius of the Earth)
   return $d;
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
