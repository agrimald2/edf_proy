<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Main;

class MainImport implements ToModel, WithHeadingRow
{
    /**
     * @TODO | Optimize this using chunks of 1000 | Fix Insert to DB review Model Main
     */
    public function model(array $row)
    {
        return new Main([
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
            'SALA' => $row['sala'] ?? null,
            'PROMEDIO_CU_3M' => $row['promedio_cu_3m'] ?? null,
            'N_EDF' => $row['n_edf'] ?? null,
            'N_PUERTAS' => $row['n_puertas'] ?? null,
            'SEGMENTO_EJECUCION' => $row['segmento_ejecucion'] ?? null,
            'POTENCIAL' => $row['potencial'] ?? null,
            'CONDICION' => $row['condicion'] ?? null,
            'PUERTAS_A_NEGOCIAR' => $row['puertas_a_negociar'] ?? null,
            'NEGOCIADO' => $row['negociado_status'] ?? null,
            'CUOTA' => $row['cuota'] ?? null,
        ]);
    }
}

?>
