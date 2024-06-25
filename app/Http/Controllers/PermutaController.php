<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permuta;
use Log;
use Illuminate\Support\Facades\Auth;

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
        /**
         * Enviar el "SV" al entrar a la ruta
         */
        
        $requestData = $request->all();
        
        $validatedData = $request->validate([
            'sv' => 'string',
            'clientCode' => 'required|string',
            'volumeCU' => 'required|string',
            'location_id' => 'required|integer',
            'route' => 'required|string',
            'subcanal' => 'required|string',
            'haveEdf' => 'required|boolean',
            'condition' => 'required|string',
            'doorsToNegotiate' => 'required|integer',
            'reason' => 'required|string',
            'justification' => 'string|nullable',
        ]);

        $permuta = Permuta::create([
            'sv' => $validatedData['sv'],
            'cod_cliente' => $validatedData['clientCode'],
            'volume' => $validatedData['volumeCU'],
            'location_id' => $validatedData['location_id'],
            'route' => $validatedData['route'],
            'subcanal' => $validatedData['subcanal'],
            'have_edf' => $validatedData['haveEdf'],
            'condition' => $validatedData['condition'],
            'doors_to_negotiate' => $validatedData['doorsToNegotiate'],
            'reason' => $validatedData['reason'],
            'justification' => $validatedData['justification'] ?? null,
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

    /**
     * Get permutas with Supervisor instance status.
     */
    public function getGestorPermutas($route)
    {
        /**
         * @TODO - Cada Permuta debe tener un código de supervisor "SV" - Para poder filtrar las rutas por código de supervisor
         */
        $permutas = Permuta::where('route', $route)
                            ->with('location')
                            ->get();
        return response()->json($permutas);
    }

    /**
     * Get permutas with Supervisor instance status.
     */
    public function getSupervisorPermutas($sv)
    {
        /**
         * @TODO - Cada Permuta debe tener un código de supervisor "SV" - Para poder filtrar las rutas por código de supervisor
         */
        $permutas = Permuta::where('instance_status', 'Supervisor')
                            ->where('sv', $sv)
                            ->with('location')
                            ->get();
        return response()->json($permutas);
    }


    /**
     * Get permutas with Gerente instance status.
     */
    public function getGerentePermutas()
    {
        $user = Auth::user();

        $permutas = Permuta::whereIn('instance_status', ['Gerente', 'Trade'])
                            ->with('location')
                            ->whereHas('location', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->get();
        
        return response()->json($permutas);
    }
    /**
     * Get permutas with Trade instance status.
     */
    public function getTradePermutas()
    {
        $permutas = Permuta::where('instance_status', 'Trade')->with('location')->get();
        return response()->json($permutas);
    }

    /**
     * Approve the specified permuta.
     */
    /**
     * Approve the specified permuta by Supervisor.
     */
    public function approveBySupervisor(string $id, string $sv)
    {
        Log::debug($sv);
        $permuta = Permuta::findOrFail($id);
        $permuta->supervisor_status = 'Approved';
        $permuta->supervisor_approved_by = $sv;
        $permuta->supervisor_approved_at = now();
        $permuta->instance_status = 'Gerente';
        $permuta->save();

        return response()->json($permuta);
    }

    /**
     * Reject the specified permuta by Supervisor.
     */
    public function rejectBySupervisor(Request $request, string $id)
    {        
        $validatedData = $request->validate([
            'rejected_reason' => 'required|string',
            'rejected_comments' => 'nullable|string',
        ]);

        $permuta = Permuta::findOrFail($id);
        $permuta->supervisor_status = 'Rejected';
        $permuta->supervisor_rejected_reason = $validatedData['rejected_reason'];
        $permuta->supervsior_rejected_comments = $validatedData['rejected_comments'];
        $permuta->save();

        return response()->json($permuta);
    }

    /**
     * Approve the specified permuta by Gerente.
     */
    public function approveByGerente(string $id)
    {
        $permuta = Permuta::findOrFail($id);
        $permuta->gerente_status = 'Approved';
        $permuta->gerente_approved_by = auth()->check() ? auth()->user()->name : 'Not Logged User';
        $permuta->gerente_approved_at = now();
        $permuta->instance_status = 'Trade';
        $permuta->save();

        return response()->json($permuta);
    }

    /**
     * Reject the specified permuta by Gerente.
     */
    public function rejectByGerente(Request $request, string $id)
    {        
        $validatedData = $request->validate([
            'rejected_reason' => 'required|string',
            'rejected_comments' => 'nullable|string',
        ]);

        $permuta = Permuta::findOrFail($id);
        $permuta->gerente_status = 'Rejected';
        $permuta->gerente_rejected_reason = $validatedData['rejected_reason'];
        $permuta->gerente_rejected_comments = $validatedData['rejected_comments'];
        $permuta->save();

        return response()->json($permuta);
    }

    /**
     * Approve the specified permuta by Trade.
     */
    public function approveByTrade(string $id)
    {
        $permuta = Permuta::findOrFail($id);
        $permuta->trade_status = 'Approved';
        $permuta->trade_approved_by = auth()->check() ? auth()->user()->name : 'Not Logged User';
        $permuta->trade_approved_at = now();
        $permuta->save();

        return response()->json($permuta);
    }

    /**
     * Reject the specified permuta by Trade.
     */
    public function rejectByTrade(Request $request, string $id)
    {        
        $validatedData = $request->validate([
            'rejected_reason' => 'required|string',
            'rejected_comments' => 'nullable|string',
        ]);

        $permuta = Permuta::findOrFail($id);
        $permuta->trade_status = 'Rejected';
        $permuta->trade_rejected_reason = $validatedData['rejected_reason'];
        $permuta->trade_rejected_comments = $validatedData['rejected_comments'];
        $permuta->save();

        return response()->json($permuta);
    }
    
}
