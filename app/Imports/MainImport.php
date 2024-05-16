<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Main;

class MainImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $fields = [
            'COD_CLIENTE', 'RUTA', 'FREC_VISITA', 'CLIENTE', 'DIRECCIÓN', 'SV', 'GV', 'SEGMENTO',
            'COD_SUBCANAL', 'NOMBRE_SUBCANAL', 'TAMAÑO', 'SALA', 'PROMEDIO_CU_3M', 'N_EDF',
            'N_PUERTAS', 'SEGMENTO_EJECUCIÓN', 'POTENCIAL', 'CONDICION', 'PUERTAS_A_NEGOCIAR',
            'NEGOCIADO', 'CUOTA'
        ];

        $modelData = [];
        foreach ($fields as $field) {
            $key = strtolower($field);
            if (isset($row[$key])) {
                $modelData[$field] = $row[$key];
            }
        }

        return new Main($modelData);
    }
}

?>
