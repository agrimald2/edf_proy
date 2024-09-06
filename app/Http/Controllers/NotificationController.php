<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function getNotificacions(){
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    public function getActiveNotificacions(){
        $today = now()->startOfDay();
        $notifications = Notification::where('active', true)
            ->where(function ($query) use ($today) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $today);
            })
            ->get();
        return response()->json($notifications);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required',
            'link' => '',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'active' => 'sometimes|boolean',
        ]);

        $notification = Notification::create($validatedData);
        return response()->json(['success' => 'Notification created successfully.']);
    }

    public function update(Request $request, Notification $notification)
    {
        $validatedData = $request->validate([
            'content' => 'required',
            'link' => '',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'active' => 'sometimes|boolean',
        ]);

        $notification->update($validatedData);
        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return ['success' => 'Notification deleted successfully.'];
    }

    public function toggleStatus(Notification $notification)
    {
        $notification->active = !$notification->active;
        $notification->save();
        return response()->json(['success' => 'Notification status toggled successfully.']);
    }
}
