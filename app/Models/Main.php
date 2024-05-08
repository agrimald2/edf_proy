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
        'DIRECCIÓN',
        'SV',
        'GV',
        'SEGMENTO',
        'COD_SUBCANAL',
        'NOMBRE_SUBCANAL',
        'TAMAÑO',
        'SALA',
        'PROMEDIO_CU_3M',
        'N_EDF',
        'N_PUERTAS',
        'SEGMENTO_EJECUCIÓN',
        'NEGOCIADO',
        'POTENCIAL',
        'CONDICION',
        'PUERTAS_A_NEGOCIAR',
        'STATUS',
        'CUOTA',
        'FECHA_PROGRAMACION',
    ];
}
