<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Event;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard según el rol del usuario
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Si es ADMIN, mostrar estadísticas globales
        if ($user->isAdmin()) {
            $stats = [
                'total_users' => User::count(),
                'total_admins' => User::role('ADMIN')->count(),
                'total_agencieros' => User::role('AGENCIERO')->count(),
                'total_colaboradores' => User::role('COLABORADOR')->count(),
                'active_users' => User::active()->count(),
                'inactive_users' => User::where('is_active', false)->count(),
                'recent_users' => User::with(['roles', 'agencia'])->latest()->take(5)->get(),
            ];
            
            return view('admin.dashboard', compact('stats'));
        }
        
        // Si es AGENCIERO, mostrar solo datos de su agencia
        if ($user->isAgenciero()) {
            $agencia = $user->agencia;
            
            // Si no tiene agencia, crear una
            if (!$agencia) {
                $agencia = \App\Models\Agencia::create([
                    'nombre' => 'Agencia de ' . $user->name,
                    'ubicacion' => '',
                    'telefono' => '',
                ]);
                
                $user->update(['agencia_id' => $agencia->id]);
                $agencia = $user->fresh()->agencia;
            }
            
            $stats = [
                'total_users' => $agencia->users()->count(),
                'total_agencieros' => $agencia->users()->role('AGENCIERO')->count(),
                'total_colaboradores' => $agencia->users()->role('COLABORADOR')->count(),
                'active_users' => $agencia->users()->active()->count(),
                'inactive_users' => $agencia->users()->where('is_active', false)->count(),
                'agencia' => $agencia,
            ];
            
            return view('agenciero.dashboard', compact('stats'));
        }
        
        // Si es COLABORADOR, mostrar vista con datos reales
        if ($user->isColaborador()) {
            // Obtener tareas del colaborador
            $allTasks = Task::where('user_id', $user->id)->get();
            $pendingTasks = $allTasks->whereIn('status', ['todo', 'in_progress']);
            $highPriorityTasks = $pendingTasks->where('priority', 'high');
            
            // Obtener eventos de hoy
            $today = now()->toDateString();
            $eventsToday = Event::where('agencia_id', $user->agencia_id)
                ->whereDate('start_time', $today)
                ->orderBy('start_time')
                ->get();
            
            // Obtener próximo evento
            $nextEvent = Event::where('agencia_id', $user->agencia_id)
                ->where('start_time', '>', now())
                ->orderBy('start_time')
                ->first();
            
            // Obtener autos asignados
            $vehiclesAssigned = Vehicle::where('agencia_id', $user->agencia_id)
                ->get();
            
            $stats = [
                'pending_tasks' => $pendingTasks->count(),
                'high_priority_tasks' => $highPriorityTasks->count(),
                'events_today' => $eventsToday->count(),
                'next_event' => $nextEvent,
                'vehicles_assigned' => $vehiclesAssigned->count(),
                'active_negotiations' => $vehiclesAssigned->where('status', 'negotiation')->count(),
                'priority_tasks' => $allTasks->whereIn('status', ['todo', 'in_progress'])->sortByDesc('priority')->take(4),
                'upcoming_events' => Event::where('agencia_id', $user->agencia_id)
                    ->where('start_time', '>', now())
                    ->orderBy('start_time')
                    ->take(3)
                    ->get(),
                'recent_vehicles' => $vehiclesAssigned->take(5),
            ];
            
            return view('colaborador.dashboard', compact('stats'));
        }
        
        abort(403, 'No tienes permiso para acceder al dashboard');
    }
}
