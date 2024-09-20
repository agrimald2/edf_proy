<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permuta;
use App\Models\BlackList;
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
         * Validar que el código de cliente no esté en la lista negra y no empiece con cero
         */
        if (substr($request->clientCode, 0, 1) === '0') {
            return response()->json(['error' => 'El código de cliente no puede empezar con cero.'], 400);
        }

        $blackList = BlackList::where('client_code', $request->clientCode)->first();
        if ($blackList) {
            return response()->json(['error' => 'El código de cliente está en la lista negra.'], 400);
        }

        $requestData = $request->all();
        
        try {
            $validatedData = $request->validate([
                'sv' => 'string',
                'clientCode' => 'required|string|max:7',
                'volumeCU' => 'required|string',
                'location_id' => 'required|integer',
                'route' => 'required|string',
                'subcanal' => 'required|string',
                'haveEdf' => 'required|boolean',
                'condition' => 'required|string',
                'doorsToNegotiate' => 'required',
                'reason' => 'required|string',
                'justification' => 'string|nullable',
            ], [
                'clientCode.required' => 'El campo código de cliente es obligatorio.',
                'clientCode.string' => 'El campo código de cliente debe ser una cadena de texto.',
                'clientCode.max' => 'El campo código de cliente no debe ser mayor a 7 caracteres.',
                'volumeCU.required' => 'El campo volumen CU es obligatorio.',
                'volumeCU.string' => 'El campo volumen CU debe ser una cadena de texto.',
                'location_id.required' => 'El campo locación es obligatorio.',
                'location_id.integer' => 'El campo locación debe ser un número entero.',
                'route.required' => 'El campo ruta es obligatorio.',
                'route.string' => 'El campo ruta debe ser una cadena de texto.',
                'subcanal.required' => 'El campo subcanal es obligatorio.',
                'subcanal.string' => 'El campo subcanal debe ser una cadena de texto.',
                'haveEdf.required' => 'El campo tiene EDF es obligatorio.',
                'haveEdf.boolean' => 'El campo tiene EDF debe ser verdadero o falso.',
                'condition.required' => 'El campo condición es obligatorio.',
                'condition.string' => 'El campo condición debe ser una cadena de texto.',
                'doorsToNegotiate.required' => 'El campo puertas a negociar es obligatorio.',
                'reason.required' => 'El campo motivo es obligatorio.',
                'reason.string' => 'El campo motivo debe ser una cadena de texto.',
                'justification.string' => 'El campo justificación debe ser una cadena de texto.',
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
        } catch (\Exception $e) {
            Log::error('La validación o creación falló: ' . $e->getMessage());
            return response()->json(['error' =>  $e->getMessage()], 400);
        }
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
        $permutas = Permuta::where('sv', $sv)
                            ->with('location')
                            ->get();
        return response()->json($permutas);
    }

    public function getSupervisorPendingPermutas($sv)
    {
        $permutas = Permuta::where('sv', $sv)
                            ->where('instance_status', 'Supervisor')
                            ->where('supervisor_status', 'Pending')
                            ->with('location')
                            ->get();
        return response()->json($permutas);
    }

    public function getGerentePendingPermutas()
    {
        $user = Auth::user();

        $permutas = Permuta::whereIn('instance_status', ['Gerente', 'Trade'])
                            ->where('instance_status', 'Gerente')
                            ->where('gerente_status', 'Pending')
                            ->with(['location', 'location.subregion'])
                            ->whereHas('location', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
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
                            ->with(['location', 'location.subregion'])
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
        $permutas = Permuta::where('instance_status', 'Trade')
                            ->with(['location', 'location.subregion.region'])
                            ->get();
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
    public function approveByGerente(string $id, string $name)
    {
        $permuta = Permuta::findOrFail($id);
        $permuta->gerente_status = 'Approved';
        $permuta->gerente_approved_by = $name;
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
