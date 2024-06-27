<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'COD_CLIENTE',
        'RUTA',
        'FREC_VISITA',
        'CLIENTE',
        'DIRECCION',
        'SV',
        'GV',
        'SEGMENTO',
        'COD_SUBCANAL',
        'NOMBRE_SUBCANAL',
        'TAMANO',
        'PROMEDIO_CU_3M',
        'N_EDF',
        'N_PUERTAS',
        'SEGMENTO_EJECUCION',
        'NEGOCIADO',
        'POTENCIAL',
        'CONDICION',
        'PUERTAS_A_NEGOCIAR',
        'STATUS',
        'SV_LIMIT',
        'LOCACION',
        'CUOTA',
        'TALLER',
        'FECHA_PROGRAMACION',
    ];
}
