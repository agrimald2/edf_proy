<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Main;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class MainImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
     * Optimize this using chunks of 1000
     */
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row) {
            $data[] = [
                'COD_CLIENTE' => $row['cod_cliente'] ?? null,
                'RUTA' => $row['ruta'] ?? null,
                'FREC_VISITA' => $row['frec_visita'] ?? null,
                'CLIENTE' => $row['cliente'] ?? null,
                'DIRECCION' => $row['direccion'] ?? null,
                'SV' => $row['sv'] ?? null,
                'GV' => $row['gv'] ?? null,
                'SEGMENTO' => $row['segmento'] ?? null,
                'COD_SUBCANAL' => $row['cod_subcanal'] ?? null,
                'NOMBRE_SUBCANAL' => $row['nombre_subcanal'] ?? null,
                'TAMANO' => $row['tamano'] ?? null,
                'PROMEDIO_CU_3M' => $row['promedio_cu_3m'] ?? null,
                'N_EDF' => $row['n_edf'] ?? null,
                'N_PUERTAS' => $row['n_puertas'] ?? null,
                'SEGMENTO_EJECUCION' => $row['segmento_ejecucion'] ?? null,
                'POTENCIAL' => $row['potencial'] ?? null,
                'CONDICION' => $row['condicion'] ?? null,
                'PUERTAS_A_NEGOCIAR' => $row['puertas_a_negociar'] ?? null,
                'NEGOCIADO' => $row['negociado_status'] ?? null,
                'STATUS' => $row['status'] ?? null,
                'SV_LIMIT' => $row['sv_limit'] ?? null,
                'CUOTA' => $row['cuota'] ?? null,
                'TALLER' => $row['taller'] ?? null,
                'LOCACION' => $row['locacion'] ?? null,
                'PROMEDIO_MES' => $row['promedio_mes'] ?? null,
                'EDF_NEGOCIADOS' => $row['edf_negociados'] ?? null,
            ];
        }

        try {
            DB::table('mains')->insert($data);
        } catch (\Exception $e) {
            Log::error('Error processing rows: ' . $e->getMessage());
        }
    }

    /**
     * Specify the chunk size for reading
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}

?>
