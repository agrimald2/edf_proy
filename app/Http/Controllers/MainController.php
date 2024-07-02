<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use App\Models\SubRegion;
use App\Models\Location;
use App\Models\Region;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MainImport;

class MainController extends Controller
{
    public function search(){
        return Inertia::render('EDF/Search');
    }

    public function getInfoByRuta($ruta){
        
        $cuota = Main::where('RUTA', $ruta)->first()->CUOTA ?? 'N/A' ;
        $clients = Main::where('RUTA', $ruta)->get();
        $negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'PENDIENTE')->count();
        $gv = Main::where('RUTA', $ruta)->first()->GV ?? 'N/A';
        $sv = Main::where('RUTA', $ruta)->first()->SV ?? 'N/A';

        $negociated_by_sv = Main::where('SV', $sv)->where('NEGOCIADO', 'NEGOCIADO')->count();;

        $pending = is_numeric($cuota) ? $cuota - $negociated_by_sv : 'N/A';
        if (is_numeric($pending) && $pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        return Inertia::render('EDF/MVP2/InfoByRuta', [
            'sv' => $sv,
            'ruta' => $ruta,
            'clients' => $clients,
            'negociados' => $negociados,
            'noNegociados' => $noNegociados,
            'gv' => $gv,
            'cuota' => $cuota, 
            'pending' => $pending,
        ]); 
    } 

    public function replaceDataFromExcel(Request $request){
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,csv',
        ]);
    
        DB::table('mains')->truncate(); // Empty the Main table
    
        try {
            Excel::import(new MainImport, $request->file('excel')); // Import the data
            return back()->with('success', 'Data has been replaced successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getInfoByMesa($mesa){     
        $cuota = Main::where('SV', $mesa)->first()->CUOTA ?? 'N/A';
        $clients = Main::where('SV', $mesa)->get();
        $negociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'PENDIENTE')->count();
        $gv = Main::where('SV', $mesa)->first()->GV ?? 'N/A';
        $pending = is_numeric($cuota) ? $cuota - $negociados : 'N/A';
        if (is_numeric($pending) && $pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        return Inertia::render('Supervisor/InfoByMesa', [
            'mesa' => $mesa,
            'clients' => $clients,
            'negociados' => $negociados,
            'noNegociados' => $noNegociados,
            'gv' => $gv,
            'cuota' => $cuota, 
            'pending' => $pending,
        ]); 
    } 

    public function showPermutasAdmin(){
        return Inertia::render('Admin/Permutas/Index');
    }

    public function loginByCode($code){
        if (stripos($code, 'SV') !== false) {
            // Supervisor
            return redirect()->route('infoByMesa', ['mesa' => $code]);
        } else {
            // Ruta
            return redirect()->route('infoByRuta', ['ruta' => $code]);
        }
    }

    public function getSubRegions(){
        $subregions = SubRegion::all();
        return response()->json($subregions);
    }

    public function getLocations(){
        $locations = Location::all();
        return response()->json($locations);
    }

    public function getRegions(){
        $regions = Region::with(['subRegions', 'subRegions.locations'])->get();
        return response()->json($regions);
    }
}
