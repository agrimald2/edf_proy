<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use App\Models\Location;
use DB;
use Log;

class GestorController extends Controller
{
    public function showPermutasList($route){     
        $sv = Main::where('RUTA', $route)->first()->SV ?? 'N/A';
        $gv = Main::where('RUTA', $route)->first()->GV ?? 'N/A';
        
        $location = Main::where('RUTA', $route)->first()->LOCACION ?? 'N/A';
        
        $location = Location::where('name', $location)->first();
        $location_id = $location ? $location->id : 2;

        return Inertia::render('Gestor/Permutas/List', [
                'supervisor' => 'Alonso',
                'mesa' => 'A',
                'route' => $route,
                'haveAvailableLimit' => true,
                'sv' => $sv,
                'gv' => $gv,
                'location_id' => $location_id
        ]); 
    } 
}
