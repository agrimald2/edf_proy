<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permuta;
use Log;

class PermutaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permutas = Permuta::all();
        return response()->json($permutas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view or form for creating a new permuta
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $validatedData = $request->validate([
            'clientCode' => 'required|string',
            'volumeCU' => 'required|string',
            'location' => 'required|string',
            'route' => 'required|string',
            'subcanal' => 'required|string',
            'haveEdf' => 'required|boolean',
            'condition' => 'required|string',
            'doorsToNegotiate' => 'required|integer',
            'reason' => 'required|string',
        ]);


        $permuta = Permuta::create([
            'cod_cliente' => $validatedData['clientCode'],
            'volume' => $validatedData['volumeCU'],
            'location' => $validatedData['location'],
            'route' => $validatedData['route'],
            'subcanal' => $validatedData['subcanal'],
            'have_edf' => $validatedData['haveEdf'],
            'condition' => $validatedData['condition'],
            'doors_to_negotiate' => $validatedData['doorsToNegotiate'],
            'reason' => $validatedData['reason'],
        ]);

        return response()->json($permuta, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permuta = Permuta::findOrFail($id);
        return response()->json($permuta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Return a view or form for editing the specified permuta
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'cod_cliente' => 'required|string',
            'volume' => 'required|string',
            'location' => 'required|string',
            'route' => 'required|string',
            'subcanal' => 'required|string',
            'have_edf' => 'required|boolean',
            'condition' => 'required|string',
            'doors_to_negotiate' => 'required|integer',
            'reason' => 'required|string',
        ]);

        $permuta = Permuta::findOrFail($id);
        $permuta->update($validatedData);
        return response()->json($permuta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permuta = Permuta::findOrFail($id);
        $permuta->delete();
        return response()->json(null, 204);
    }
}
