<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Main;

class MainImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Main([
            'COD_CLIENTE' => $row['cod_cliente'],
            'RUTA' => $row['ruta'],
            'FREC_VISITA' => $row['frec_visita'],
            'CLIENTE' => $row['cliente'],
            'DIRECCIÓN' => $row['direccion'],
            'SV' => $row['sv'],
            'GV' => $row['gv'],
            'SEGMENTO' => $row['segmento'],
            'COD_SUBCANAL' => $row['cod_subcanal'],
            'NOMBRE_SUBCANAL' => $row['nombre_subcanal'],
            'TAMAÑO' => $row['tamano'],
            'SALA' => $row['sala'],
            'PROMEDIO_CU_3M' => $row['promedio_cu_3m'],
            'N_EDF' => $row['n_edf'],
            'N_PUERTAS' => $row['n_puertas'],
            'SEGMENTO_EJECUCIÓN' => $row['segmento_ejecucion'],
            'POTENCIAL' => $row['potencial'],
            'CONDICION' => $row['condicion'],
            'PUERTAS_A_NEGOCIAR' => $row['puertas_a_negociar'],
            'NEGOCIADO' => $row['negociado_status'],
            'CUOTA' => $row['cuota'],
        ]);
    }
}

?>