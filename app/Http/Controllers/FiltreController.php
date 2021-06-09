<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DouaneFiltre;
use Illuminate\Support\Facades\DB;

class FiltreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFiltreDouanes(Request $request)
    {

        return DB::table("douane_filtres")->get();


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFiltreBSC(Request $request)
    {

        return DB::table("bsc_filtres")->get();


    }



}
