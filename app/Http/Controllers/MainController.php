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
use Log;

class MainController extends Controller
{
    public function search(){
        return Inertia::render('EDF/Search');
    }

    public function getInfoByRuta($ruta){
        
        $cuota = Main::where('RUTA', $ruta)->first()->CUOTA ?? 'N/A' ;
        $clients = Main::where('RUTA', $ruta)->get();

        $negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->distinct('COD_CLIENTE')->count('COD_CLIENTE');
        $noNegociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'PENDIENTE')->distinct('COD_CLIENTE')->count('COD_CLIENTE');

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
        Log::debug($request);
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv',
        ]);
    
        $file = $request->file('excel');
        $data = \Excel::toArray([], $file)[0];
    
        DB::table('mains')->truncate(); // Empty the Main table
    
        try {
            // Skip the header row
            $data = array_slice($data, 1);
            $batchSize = 1000; // Adjust batch size as needed
            $batches = array_chunk($data, $batchSize);
    
            foreach ($batches as $batch) {
                $insertData = array_map(function($row) {
                    return [
                        'COD_CLIENTE' => $row[0],
                        'RUTA' => $row[1],
                        'FREC_VISITA' => $row[2],
                        'CLIENTE' => $row[3],
                        'DIRECCION' => $row[4],
                        'SV' => $row[5],
                        'GV' => $row[6],
                        'NOMBRE_SV' => $row[7],
                        'TAMANO' => $row[8],
                        'PROMEDIO_CU_3M' => $row[9],
                        'N_EDF' => $row[10],
                        'N_PUERTAS' => $row[11],
                        'CONDICION' => $row[12],
                        'PUERTAS_A_NEGOCIAR' => $row[13],
                        'CONDICION_2' => $row[14],
                        'PUERTAS_A_NEGOCIAR_2' => $row[15],
                        'NEGOCIADO' => $row[16],
                        'STATUS' => $row[17],
                        'CUOTA' => $row[18],
                        'SV_LIMIT' => $row[19],
                        'LOCACION' => $row[20],
                        'TALLER' => $row[21],
                        'FECHA_NEGOCIADO' => $row[22],
                    ];
                }, $batch);
    
                Main::insert($insertData);
            }
    
            return back()->with('success', 'Data has been replaced successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
    public function getInfoByMesa($mesa){     
        $cuota = Main::where('SV', $mesa)->first()->CUOTA ?? 'N/A';
        $clients = Main::where('SV', $mesa)->get();

        $gestores = Main::select('RUTA', 'GV')
            ->distinct()
            ->get()
            ->map(function($gestor) {
                $ruta = $gestor->RUTA;
                $gv = $gestor->GV;
                $total_negociados = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->count();
                $n_puertas_negociadas_repotenciadas = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->where('CONDICION', 'REPOTENCIADO')->sum('PUERTAS_A_NEGOCIAR');
                $n_puertas_negociadas_nuevas = Main::where('RUTA', $ruta)->where('NEGOCIADO', 'NEGOCIADO')->where('CONDICION', 'NUEVO')->sum('PUERTAS_A_NEGOCIAR');

                return [
                    'ruta' => $ruta,
                    'gv' => $gv,
                    'total_negociados' => $total_negociados,
                    'n_puertas_negociadas_repotenciadas' => $n_puertas_negociadas_repotenciadas,
                    'n_puertas_negociadas_nuevas' => $n_puertas_negociadas_nuevas,
                ];
            })
            ->sortBy('total_negociados')
            ->values();

        
        $negociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'NEGOCIADO')->count();
        $noNegociados = Main::where('SV', $mesa)->where('NEGOCIADO', 'PENDIENTE')->count();

        
        $gv = Main::where('SV', $mesa)->first()->GV ?? 'N/A';
        $pending = is_numeric($cuota) ? $cuota - $negociados : 'N/A';
        if (is_numeric($pending) && $pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        // get progress percentage between $negociados and cuota

        $progress = is_numeric($cuota) && $cuota > 0 ? ($negociados / $cuota) * 100 : 0;
        
        return Inertia::render('Supervisor/InfoByMesa', [
            'mesa' => $mesa,
            'clients' => $clients,
            'negociados' => $negociados,
            'noNegociados' => $noNegociados,
            'gv' => $gv,
            'cuota' => $cuota, 
            'pending' => $pending,
            'progress' => $progress,
            'gestores' => $gestores
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
