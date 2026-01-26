<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $query = Event::with('user');
        
        if ($user && !$user->isAdmin()) {
            $query->where('agencia_id', $user->agencia_id);
        }
        
        // Get all events for the current month
        $now = now();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $allEvents = $query->whereBetween('start_time', [$startOfMonth, $endOfMonth])->get();
        
        // Group events by date for easier rendering
        $eventsByDate = $allEvents->groupBy(function ($event) {
            /** @var Event $event */
            return $event->start_time->format('Y-m-d');
        });
        
        $stats = [
            'total' => $query->count(),
            'today' => $query->clone()->today()->count(),
            'upcoming' => $query->clone()->where('start_time', '>', now())->count(),
        ];
        
        return view('events.index', compact('allEvents', 'eventsByDate', 'stats'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:meeting,delivery,test_drive,service,other',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string',
            'client_name' => 'nullable|string',
            'client_phone' => 'nullable|string',
        ]);
        
        $validated['user_id'] = $user->id;
        $validated['agencia_id'] = $user->agencia_id;
        
        Event::create($validated);
        
        return redirect()->route('admin.events.index')->with('success', 'Evento creado exitosamente');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:meeting,delivery,test_drive,service,other',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string',
            'client_name' => 'nullable|string',
            'client_phone' => 'nullable|string',
        ]);
        
        $event->update($validated);
        
        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado exitosamente');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado exitosamente');
    }

    public function calendar()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $query = Event::with('user');
        
        if ($user && !$user->isAdmin()) {
            $query->where('agencia_id', $user->agencia_id);
        }
        
        $events = $query->get()->map(function ($event) {
            /** @var Event $event */
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->toISOString(),
                'end' => $event->end_time->toISOString(),
                'backgroundColor' => $this->getColorByType($event->type),
                'borderColor' => $this->getColorByType($event->type),
            ];
        });
        
        return view('events.calendar', compact('events'));
    }

    private function getColorByType($type)
    {
        return match($type) {
            'meeting' => '#3b82f6',      // blue
            'delivery' => '#10b981',      // green
            'test_drive' => '#f59e0b',    // orange
            'service' => '#8b5cf6',       // purple
            default => '#6b7280',         // gray
        };
    }
}
