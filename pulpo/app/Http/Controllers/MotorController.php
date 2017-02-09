<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ActualizarPosiciones;
use Illuminate\Support\Facades\Redis;


class MotorController extends Controller
{

  public function index()
  {
    return Redis::get('switch');
  }

  public function show($op)
  {
    switch ($op) {
      case "start":
        Redis::set('switch',"start");
        dispatch(new ActualizarPosiciones());
        return "start";//response()->json(['estado' => 'ENCENDIDO']);
      case "stop":
        Redis::set('switch',"stop");
        return "stop";//response()->json(['estado' => 'APAGADO']);
    }
    return response()->json(['message' => 'Record not found'],404);
  }
}
