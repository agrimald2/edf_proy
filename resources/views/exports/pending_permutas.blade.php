<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>COD_CLIENTE</th>
            <th>FECHA DE PERMUTA</th>
            <th>Volumen en CU</th>
            <th>Condición</th>
            <th>Puertas a Negociar</th>
            <th>Motivo</th>
            <th>Justificación</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permutas as $permuta)
            <tr>
                <td>{{ $permuta->id }}</td>
                <td>{{ $permuta->cod_cliente }}</td>
                <td>{{ $permuta->fecha_de_permuta }}</td>
                <td>{{ $permuta->volumen_en_cu }}</td>
                <td>{{ $permuta->condición }}</td>
                <td>{{ $permuta->puertas_a_negotiar }}</td>
                <td>{{ $permuta->motivo }}</td>
                <td>{{ $permuta->justificación }}</td>
                <td>{{ $permuta->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>