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
    public function search(){
        return Inertia::render('EDF/Search');
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
        $pending = is_numeric($cuota) ? $cuota - $negociados : 'N/A';
        if (is_numeric($pending) && $pending < 0) {
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
    
        try {
            Excel::import(new MainImport, $request->file('excel')); // Import the data
            return back()->with('success', 'Data has been replaced successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getInfoByMesa($mesa){     
        # Nombre de Supervisor campo en DB
        # 
        
           
        return Inertia::render('Supervisor/InfoByMesa', [
                'supervisor' => 'Alonso',
        ]); 
    } 


    public function showPermutasAdmin(){
        return Inertia::render('Admin/Permutas/Index');
    }
}
