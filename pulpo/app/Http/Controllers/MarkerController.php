<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MarkerService;

use App\Helpers\Utils;

class MarkerController extends Controller
{
    protected $markers;

    public function __construct(MarkerService $markers)
    {
        $this->markers = $markers;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $northeast = $request->input('northeast');
        $southwest = $request->input('southwest');
        $ubicacion = Utils::randUbicacion($northeast,$southwest);
        return $this->markers->guardar($ubicacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
