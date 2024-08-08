<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Volumen</th>
            <th>Locación</th>
            <th>Ruta</th>
            <th>Subcanal</th>
            <th>Fecha de Aprobación</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permutas as $permuta)
            <tr>
                <td>{{ $permuta->id }}</td>
                <td>{{ $permuta->cod_cliente }}</td>
                <td>{{ $permuta->volume }}</td>
                <td>{{ $permuta->location->name }}</td>
                <td>{{ $permuta->route }}</td>
                <td>{{ $permuta->subcanal }}</td>
                <td>{{ $permuta->trade_approved_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>