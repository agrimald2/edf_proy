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

    public function showPermutasPendingList(){     
        return Inertia::render('Gerente/Permutas/PendingApproval', [
                'supervisor' => 'Alonso',
        ]); 
    } 

    public function getGerenteLocations() {
        $user = Auth::user();
        $userId = Auth::id();
        $locations = Location::where('user_id', $userId)->get();


        return response()->json($locations);
    }

    public function getPermutasPendingList()
    {
        $user = Auth::user();

        $permutas = Permuta::whereIn('instance_status', ['Gerente', 'Trade'])
                            ->with(['location', 'location.subregion'])
                            ->whereHas('location', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->get();
        
        return response()->json($permutas);
    }
}