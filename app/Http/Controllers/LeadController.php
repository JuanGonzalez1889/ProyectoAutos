<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $query = Lead::with(['user', 'vehicle', 'agencia']);
        
        if ($user && !$user->isAdmin()) {
            $query->where('agencia_id', $user->agencia_id);
        }
        
        $leads = $query->latest()->paginate(20);
        
        $stats = [
            'total' => $query->count(),
            'new' => (clone $query)->new()->count(),
            'active' => (clone $query)->active()->count(),
            'won' => (clone $query)->won()->count(),
            'lost' => (clone $query)->lost()->count(),
        ];
        
        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $vehicles = Vehicle::where('agencia_id', $user->agencia_id)
            ->where('status', 'available')
            ->get();
        
        return view('leads.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:new,contacted,interested,negotiating,won,lost',
            'source' => 'nullable|in:web,phone,social_media,referral,walk_in,other',
            'notes' => 'nullable|string',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'budget' => 'nullable|numeric|min:0',
            'next_follow_up' => 'nullable|date',
        ]);
        
        $validated['user_id'] = $user->id;
        $validated['agencia_id'] = $user->agencia_id;
        
        if ($request->filled('contacted_at')) {
            $validated['contacted_at'] = now();
        }
        
        Lead::create($validated);
        
        return redirect()->route('admin.leads.index')->with('success', 'Lead creado exitosamente');
    }

    public function edit(Lead $lead)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $vehicles = Vehicle::where('agencia_id', $user->agencia_id)
            ->where('status', 'available')
            ->get();
        
        return view('leads.edit', compact('lead', 'vehicles'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:new,contacted,interested,negotiating,won,lost',
            'source' => 'nullable|in:web,phone,social_media,referral,walk_in,other',
            'notes' => 'nullable|string',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'budget' => 'nullable|numeric|min:0',
            'next_follow_up' => 'nullable|date',
        ]);
        
        // Actualizar contacted_at si el status cambió
        if ($request->status !== $lead->status && in_array($request->status, ['contacted', 'interested', 'negotiating'])) {
            $validated['contacted_at'] = now();
        }
        
        $lead->update($validated);
        
        return redirect()->route('admin.leads.index')->with('success', 'Lead actualizado exitosamente');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        
        return redirect()->route('admin.leads.index')->with('success', 'Lead eliminado exitosamente');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,interested,negotiating,won,lost',
        ]);
        
        if ($request->status !== $lead->status && in_array($request->status, ['contacted', 'interested', 'negotiating'])) {
            $validated['contacted_at'] = now();
        }
        
        $lead->update($validated);
        
        return response()->json(['success' => true]);
    }
}
