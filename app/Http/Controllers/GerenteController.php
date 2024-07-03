<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Log;

class GerenteController extends Controller
{
    public function getInfoByMesa(){     
        # Nombre de Supervisor campo en DB
        return Inertia::render('Gerente/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function index(){     
        return Inertia::render('Gerente/Permutas/List', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function getGerenteLocations() {
        $user = Auth::user();
        $userId = Auth::id();
        $locations = Location::where('user_id', $userId)->get();

        Log::debug($user);
        Log::debug($userId);
        Log::debug($locations);
        return response()->json($locations);
    }
}