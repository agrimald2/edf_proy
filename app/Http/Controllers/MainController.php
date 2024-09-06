<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Main;
use App\Models\SubRegion;
use App\Models\Location;
use App\Models\Region;
use App\Models\WorkshopLocationDay;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MainImport;
use Log;

class MainController extends Controller
{
    public function search()
    {
        return Inertia::render('EDF/Search');
    }

    public function getInfoByRuta($ruta)
    {
        $currentMonth = now()->format('Y-m');


        $clients = Main::where('RUTA', $ruta)->get();
        $cuota = $clients->first()->CUOTA ?? 'N/A';


        $negociados = Main::where('RUTA', $ruta)
            ->where('FECHA_NEGOCIADO', 'like', $currentMonth . '%')
            ->get()
            ->unique('COD_CLIENTE')
            ->sum('EDF_NEGOCIADOS');

        $noNegociados = Main::where('RUTA', $ruta)
            ->where('NEGOCIADO', 'PENDIENTE')
            ->distinct('COD_CLIENTE')
            ->count('COD_CLIENTE');


        $gv = $clients->first()->GV ?? 'N/A';
        $sv = $clients->first()->SV ?? 'N/A';

        $negociated_by_sv = Main::where('SV', $sv)
            ->where('FECHA_NEGOCIADO', 'like', $currentMonth . '%')
            ->where('NEGOCIADO', 'NEGOCIADO')
            ->count();


        $clients = $clients->map(function ($client) {
            $condition = 'NUEVO';
            $dias_restantes = 0;


            if ($client->PUERTAS_A_NEGOCIAR > 0) {
                $condition = 'REPOTENCIADO';
            }


            $delay_time = WorkshopLocationDay::where('LOCACION', $client->LOCACION)
                ->where('TALLER', $client->TALLER)
                ->where('CONDICION', $condition)
                ->first();
            if (!is_int($delay_time)) {
                $delay_time = $delay_time->TIEMPO ?? 0;
            }

            if ($client->NEGOCIADO == 'NEGOCIADO' && $client->STATUS == 'NEGOCIADO') {
                $delay_time = WorkshopLocationDay::where('LOCACION', $client->LOCACION)
                    ->max('TIEMPO');

                if (!is_int($delay_time)) {
                    $delay_time = $delay_time->TIEMPO ?? 0;
                }
            }

            if ($client->NEGOCIADO == 'NEGOCIADO' && $client->STATUS == 'EN RUTA') {
                if (!is_int($delay_time)) {
                    $delay_time = $delay_time->TIEMPO ?? 0;
                }
            }

            if (!$delay_time) {
                $delay_time = 0;
            }

            if ($client->NEGOCIADO == 'NEGOCIADO' && $client->STATUS == 'NEGOCIADO') {
                $delay_time = $delay_time + 4;
            }

            $fecha_negociado = $client->FECHA_NEGOCIADO;

            if ($fecha_negociado) {
                $fecha_negociado_date = \Carbon\Carbon::createFromFormat('Y-m-d', $fecha_negociado);
                $fecha_actual = \Carbon\Carbon::now();

                $fecha_estimada = $fecha_negociado_date->copy();
                $dias_habiles_sumados = 0;

                while ($dias_habiles_sumados < $delay_time) {
                    $fecha_estimada->addDay();
                    if (!$fecha_estimada->isWeekend()) {
                        $dias_habiles_sumados++;
                    }
                }

                // Calculate remaining business days
                $dias_restantes = 0;
                $temp_date = $fecha_actual->copy();

                while ($temp_date->lessThan($fecha_estimada)) {
                    if (!$temp_date->isWeekend()) {
                        $dias_restantes++;
                    }
                    $temp_date->addDay();
                }

                // If the estimated date is in the past, calculate negative business days
                if ($fecha_actual->greaterThan($fecha_estimada)) {
                    $dias_restantes = 0;
                    $temp_date = $fecha_estimada->copy();

                    while ($temp_date->lessThan($fecha_actual)) {
                        if (!$temp_date->isWeekend()) {
                            $dias_restantes--;
                        }
                        $temp_date->addDay();
                    }
                }
            }

            $dias_restantes = $dias_restantes + 1;

            $client->dias_restantes = $dias_restantes;

            return $client;
        });

        Log::debug($cuota);
        Log::debug($negociated_by_sv);

        $pending = is_numeric($cuota) ? $cuota - $negociated_by_sv : 'N/A';
        Log::debug($pending);

        if (is_numeric($pending) && $pending < 0) {
            $pending = 0; // Ensure pending is not negative
        }

        Log::debug($pending);

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

    public function replaceDataFromExcel(Request $request)
    {
        Log::debug("Arrancó");

        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        Log::debug('Validado');
        
        $file = $request->file('excel');

        Log::debug('Requerido...');

        $data = \Excel::toArray([], $file)[0];

        Log::debug('Convertido a Array');
        
        DB::table('mains')->truncate();

        try {
            $data = array_slice($data, 1);
            $batchSize = 1000; // Adjust batch size as needed
            $batches = array_chunk($data, $batchSize);

            foreach ($batches as $batch) {
                $insertData = array_map(function ($row) {
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
                        'PU ERTAS_A_NEGOCIAR' => $row[13],
                        'CONDICION_2' => $row[14],
                        'PUERTAS_A_NEGOCIAR_2' => $row[15],
                        'NEGOCIADO' => $row[16],
                        'STATUS' => $row[17],
                        'CUOTA' => $row[18],
                        'SV_LIMIT' => $row[19],
                        'LOCACION' => $row[20],
                        'TALLER' => $row[21],
                        'FECHA_NEGOCIADO' => $row[22],
                        'PROMEDIO_MES' => $row[23],
                        'EDF_NEGOCIADOS' => $row[24],
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

    public function uploadNewDataFromExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('excel');

        $data = \Excel::toArray([], $file)[0];

        try {
            $data = array_slice($data, 1);
            $batchSize = 1000; // Adjust batch size as needed
            $batches = array_chunk($data, $batchSize);

            foreach ($batches as $batch) {
                $insertData = array_map(function ($row) {
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
                        'PU ERTAS_A_NEGOCIAR' => $row[13],
                        'CONDICION_2' => $row[14],
                        'PUERTAS_A_NEGOCIAR_2' => $row[15],
                        'NEGOCIADO' => $row[16],
                        'STATUS' => $row[17],
                        'CUOTA' => $row[18],
                        'SV_LIMIT' => $row[19],
                        'LOCACION' => $row[20],
                        'TALLER' => $row[21],
                        'FECHA_NEGOCIADO' => $row[22],
                        'PROMEDIO_MES' => $row[23],
                        'EDF_NEGOCIADOS' => $row[24],
                    ];
                }, $batch);

                Main::insert($insertData);
            }

            return back()->with('success', 'Data has been uploaded successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function getInfoByMesa($mesa)
    {
        $mesa = strtoupper($mesa);
        $cuota = Main::where('SV', $mesa)->first()->CUOTA ?? 'N/A';
        $supervisor = Main::where('SV', $mesa)->first()->NOMBRE_SV ?? 'N/A';
        $clients = Main::where('SV', $mesa)->get();

        $gestores = Main::select('RUTA', 'GV')
            ->where('SV', 'LIKE', $mesa)
            ->distinct()
            ->get()
            ->map(function ($gestor) {
                $ruta = $gestor->RUTA;
                $gv = $gestor->GV;
                $total_negociados = Main::where('RUTA', $ruta)
                    ->get()
                    ->unique('COD_CLIENTE')
                    ->sum('EDF_NEGOCIADOS');

                $n_puertas_negociadas_repotenciadas = Main::where('RUTA', $ruta)
                    ->where('NEGOCIADO', 'NEGOCIADO')
                    ->where('CONDICION', 'REPOTENCIADO')
                    ->get()
                    ->unique('COD_CLIENTE')
                    ->sum('PUERTAS_A_NEGOCIAR');

                $n_puertas_negociadas_nuevas = Main::where('RUTA', $ruta)
                    ->where('NEGOCIADO', 'NEGOCIADO')
                    ->where('CONDICION_2', 'NUEVO')
                    ->get()
                    ->unique('COD_CLIENTE')
                    ->sum('PUERTAS_A_NEGOCIAR_2');

                /*
                $n_puertas_negociadas_repotenciadas  = Main::where('RUTA', $ruta)
                    ->where('NEGOCIADO', 'NEGOCIADO')
                    ->distinct('COD_CLIENTE')
                    ->sum('PUERTAS_A_NEGOCIAR');

                $n_puertas_negociadas_nuevas = Main::where('RUTA', $ruta)
                    ->where('NEGOCIADO', 'NEGOCIADO')
                    ->distinct('COD_CLIENTE')
                    ->sum('PUERTAS_A_NEGOCIAR_2');
                */

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

        // Sum N_EDF where NEGOCIADO is NEGOCIADO || Suma de equipos de frío negociados por todas las rutas del supervisor
        $negociados = Main::where('SV', $mesa)
            ->select('COD_CLIENTE', 'EDF_NEGOCIADOS')
            ->get()
            ->unique('COD_CLIENTE')
            ->sum('EDF_NEGOCIADOS');

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
            'gestores' => $gestores,
            'supervisor' => $supervisor
        ]);
    }

    public function showPermutasAdmin()
    {
        return Inertia::render('Admin/Permutas/Index');
    }

    public function loginByCode($code)
    {
        if (stripos($code, 'SV') !== false) {
            // Check if the supervisor code exists
            $exists = Main::where('SV', $code)->exists();
            if ($exists) {
                return redirect()->route('infoByMesa', ['mesa' => $code]);
            }
        } else {
            // Check if the ruta code exists
            $exists = Main::where('RUTA', $code)->exists();
            if ($exists) {
                return redirect()->route('infoByRuta', ['ruta' => $code]);
            }
        }

        // If code does not exist, redirect back with an error message
        return redirect()->back()->withErrors(['code' => 'El código no existe.']);
    }

    public function getSubRegions()
    {
        $subregions = SubRegion::all();
        return response()->json($subregions);
    }

    public function getLocations()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function getRegions()
    {
        $regions = Region::with(['subRegions', 'subRegions.locations'])->get();
        return response()->json($regions);
    }
}
