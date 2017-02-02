<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ActualizarPosiciones;
use Illuminate\Support\Facades\Redis;


class MotorController extends Controller
{
  protected $motor;

  public function __construct(Motor $motor)
  {
      $this->motor = $motor;
  }

  public function show($op)
  {
    switch ($op) {
      case "start":
        Redis::set('switch',"false");
        dispatch(new ActualizarPosiciones());
        break;
      case "stop":
        Redis::set('switch',"true");
        break;
    }
    return;
  }
}
