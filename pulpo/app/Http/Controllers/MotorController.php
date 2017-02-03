<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ActualizarPosiciones;
use Illuminate\Support\Facades\Redis;


class MotorController extends Controller
{
  public function show($op)
  {
    switch ($op) {
      case "start":
        Redis::set('switch',"false");
        dispatch(new ActualizarPosiciones());
        return response()->json(['estado' => 'ENCENDIDO']);
      case "stop":
        Redis::set('switch',"true");
        return response()->json(['estado' => 'APAGADO']);
    }
    return response()->json(['message' => 'Record not found'],404);
  }
}
