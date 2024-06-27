<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['sub_region_id' => 1, 'name' => '79 Paci Cañete', 'user_id' => 5],
            ['sub_region_id' => 1, 'name' => '79 Paci Mala', 'user_id' => 5],
            ['sub_region_id' => 2, 'name' => '33 Paci Villa el Salvador', 'user_id' => 5],
            ['sub_region_id' => 2, 'name' => '33 Paci Chorrillos', 'user_id' => 6],
            ['sub_region_id' => 2, 'name' => 'I1 Ecobesa Callao', 'user_id' => 7],
            ['sub_region_id' => 2, 'name' => 'I1 Ecobesa Dueñas', 'user_id' => 8],
            ['sub_region_id' => 2, 'name' => '78 M. Ventanilla', 'user_id' => 9],
            ['sub_region_id' => 2, 'name' => 'I9 Ecobesa Comas', 'user_id' => 10],
            ['sub_region_id' => 2, 'name' => 'I9 Ecobesa Los Olivos', 'user_id' => 11],
            [ 'sub_region_id' => 2, 'name' => 'IA Ecobesa San Juan', 'user_id' => 12],
            [ 'sub_region_id' => 2, 'name' => 'IA Ecobesa Ate', 'user_id' => 13],
            [ 'sub_region_id' => 2, 'name' => 'IA Ecobesa Chosica', 'user_id' => 14],
            [ 'sub_region_id' => 3, 'name' => 'I7 Ecobesa Chiclayo', 'user_id' => 15],
            [ 'sub_region_id' => 3, 'name' => '94 ALPER JAEN', 'user_id' => 15],
            [ 'sub_region_id' => 3, 'name' => '59 IMPERIOS CAJAMARCA', 'user_id' => 15],
            [ 'sub_region_id' => 3, 'name' => '45 Diaz Ruiz Chota', 'user_id' => 15],
            [ 'sub_region_id' => 4, 'name' => 'ECOBESA PIURA', 'user_id' => 16],
            [ 'sub_region_id' => 4, 'name' => 'ECOBESA TUMBES', 'user_id' => 16],
            [ 'sub_region_id' => 5, 'name' => '68 PMA CHIMBOTE', 'user_id' => 17],
            [ 'sub_region_id' => 5, 'name' => '61 BAJOPONTINA HUARAZ', 'user_id' => 17],
            [ 'sub_region_id' => 6, 'name' => '43 PMA TRUJILLO', 'user_id' => 18],
            [ 'sub_region_id' => 6, 'name' => 'JE PMA PACASMAYO', 'user_id' => 18],
            [ 'sub_region_id' => 6, 'name' => 'JF PMA CHOCOPE', 'user_id' => 18],
            [ 'sub_region_id' => 6, 'name' => 'B1 HUAMACHUCO', 'user_id' => 18],
            [ 'sub_region_id' => 7, 'name' => '07 DISTRAROJ TARMA', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '08 TRAHIS PICHANAKI', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '27 HUALLPA PASCO', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '47 TRAHIS LA MERCED', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '57 BAJOPONTINA HUANCAVELICA', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '71 BAJOPONTINA HUANCAYO', 'user_id' => 19],
            [ 'sub_region_id' => 7, 'name' => '97 TRAHIS SATIPO', 'user_id' => 19],
            [ 'sub_region_id' => 8, 'name' => '24 IMPERIOS HUACHO', 'user_id' => 20],
            [ 'sub_region_id' => 8, 'name' => '28 IMPERIOS HUARAL', 'user_id' => 20],
            [ 'sub_region_id' => 9, 'name' => '63 SANTA MÓNICA TARAPOTO', 'user_id' => 21],
            [ 'sub_region_id' => 9, 'name' => '72 TRAHIS PUCALLPA', 'user_id' => 21],
            [ 'sub_region_id' => 9, 'name' => '76 TRAHIS HUANUCO', 'user_id' => 21],
            [ 'sub_region_id' => 9, 'name' => 'JC O.L. IQUITOS', 'user_id' => 21],
            [ 'sub_region_id' => 9, 'name' => '74 DISELVA TINGO MARIA', 'user_id' => 21],
            [ 'sub_region_id' => 9, 'name' => 'E5 SANTA MÓNICA MOYOBAMBA', 'user_id' => 21],
            [ 'sub_region_id' => 10, 'name' => '46 DISTRAROJ AYACUCHO', 'user_id' => 22],
            [ 'sub_region_id' => 10, 'name' => '83 CONSUELO CANALES PUQUIO', 'user_id' => 22],
            [ 'sub_region_id' => 10, 'name' => 'I3 ECOBESA ICA', 'user_id' => 22],
            [ 'sub_region_id' => 10, 'name' => 'I4 ECOBESA NAZCA', 'user_id' => 22],
            [ 'sub_region_id' => 10, 'name' => 'I5 ECOBESA PISCO', 'user_id' => 22],
            [ 'sub_region_id' => 10, 'name' => 'I6 ECOBESA CHINCHA', 'user_id' => 22],
            [ 'sub_region_id' => 11, 'name' => 'IC ECOBESA Arequipa', 'user_id' => 23],
            [ 'sub_region_id' => 11, 'name' => '06 AYA EL PEDREGAL', 'user_id' => 23],
            [ 'sub_region_id' => 11, 'name' => '38 AYA ATICO', 'user_id' => 23],
            [ 'sub_region_id' => 11, 'name' => '40 AYA CHALA', 'user_id' => 23],
            [ 'sub_region_id' => 11, 'name' => '88 AYA CAMANA', 'user_id' => 23],
            [ 'sub_region_id' => 11, 'name' => '93 COM. SAN JOSE ESPINAR', 'user_id' => 23],
            [ 'sub_region_id' => 12, 'name' => 'ID ECOBESA MOLLENDO', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '18 SALAZAR ANDAHUAYLAS', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '91 SALAZAR ABANCAY', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '95 INTICHAY QUILLABAMBA', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '25 ANDINO URUBAMBA', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '84 JHOSELIN PTO MALDONADO', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '92 ANDINO SICUANI', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => 'A0 ANDINO MACHUPICCHU', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => 'C6 JHOSELIN HUEPETUHE', 'user_id' => 24],
            [ 'sub_region_id' => 12, 'name' => '32 ANDINO CUSCO', 'user_id' => 24],
            [ 'sub_region_id' => 13, 'name' => '15 EMBID AYAVIRI', 'user_id' => 25],
            [ 'sub_region_id' => 13, 'name' => '23 EMBID YUNGUYO', 'user_id' => 25],
            [ 'sub_region_id' => 13, 'name' => '50 EMBID ILAVE', 'user_id' => 25],
            [ 'sub_region_id' => 13, 'name' => '60 EMBID DESAGUADERO', 'user_id' => 25],
            [ 'sub_region_id' => 13, 'name' => '89 EMBID JULIACA', 'user_id' => 25],
            [ 'sub_region_id' => 14, 'name' => 'AC RUTA SUR MOQUEGUA', 'user_id' => 26],
            [ 'sub_region_id' => 14, 'name' => 'BC LONCCOS Y CCALAS SAC', 'user_id' => 26],
            [ 'sub_region_id' => 14, 'name' => 'AA RUTAS DEL SUR TACNA', 'user_id' => 26],
        ];

        foreach ($locations as $location) {
            \App\Models\Location::create($location);
        }
    }
}
