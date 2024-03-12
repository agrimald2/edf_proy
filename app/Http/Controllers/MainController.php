<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;

class MainController extends Controller
{
    public function searchByRuta(){
        return Inertia::render('EDF/SearchByRuta');
    }

    public function getInfoByRuta($ruta){
        $clients = Main::where('RUTA', $ruta)->get();
        $negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'PENDIENTE')->count();
        $gv = Main::where('RUTA', $ruta)->first()->GV ?? 'N/A';
        return Inertia::render('EDF/InfoByRuta', [
                'ruta' => $ruta,
                'clients' => $clients,
                'negociados' => $negociados,
                'noNegociados' => $noNegociados,
                'gv' => $gv
        ]);
    } 
}
