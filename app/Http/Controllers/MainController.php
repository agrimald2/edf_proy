<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MainImport;

class MainController extends Controller
{
    public function searchByRuta(){
        return Inertia::render('EDF/SearchByRuta');
    }

    public function getInfoByRuta($ruta){
        $cuota = Main::where('RUTA', $ruta)->first()->CUOTA ?? 0 ;
        $clients = Main::where('RUTA', $ruta)->get();
        $negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'PENDIENTE')->count();
        $gv = Main::where('RUTA', $ruta)->first()->GV ?? 'N/A';
        $pending = $cuota - $negociados;
        if ($pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }
        
        return Inertia::render('EDF/InfoByRuta', [
                'ruta' => $ruta,
                'clients' => $clients,
                'negociados' => $negociados,
                'noNegociados' => $noNegociados,
                'gv' => $gv,
                'cuota' => $cuota, 
                'pending' => $pending,
        ]); 
    } 

    public function getInfoByRuta2($ruta){
        $cuota = Main::where('RUTA', $ruta)->first()->CUOTA ?? 'N/A' ;
        $clients = Main::where('RUTA', $ruta)->get();
        $negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'PENDIENTE')->count();
        $gv = Main::where('RUTA', $ruta)->first()->GV ?? 'N/A';
        $pending = $cuota - $negociados;
        if ($pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        return Inertia::render('EDF/MVP2/InfoByRuta', [
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
    
        Excel::import(new MainImport, $request->file('excel')); // Import the data
    
        return back()->with('success', 'Data has been replaced successfully.');
    }
}
