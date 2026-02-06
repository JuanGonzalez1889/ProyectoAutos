<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Event;
use App\Models\Vehicle;
use App\Models\Lead;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            
            // Calcular métricas reales
            $tenant = $user->tenant; // Obtener el tenant del usuario
            $needsDomain = !$tenant || !$tenant->domains()->exists();
            $needsAgencyName = !$agencia->nombre || $agencia->nombre === 'Agencia de ' . $user->name;
            $needsUserName = !$user->name || $user->name === $user->email;
            $showOnboarding = $needsDomain || $needsAgencyName || $needsUserName;
            $suggestedDomain = Str::slug($agencia->nombre ?: $user->name, '-');
            $onboarding = [
                'show' => $showOnboarding,
                'domain_suffix' => '.misaas.com',
                'suggested_domain' => $suggestedDomain ?: 'miagencia',
                'prefill_name' => $user->name,
                'prefill_agencia' => $agencia->nombre,
            ];
            
            if (!$tenant) {
                // Si no tiene tenant, no hay datos para mostrar
                $stats = [
                    'total_users' => $agencia->users()->count(),
                    'total_agencieros' => $agencia->users()->role('AGENCIERO')->count(),
                    'total_colaboradores' => $agencia->users()->role('COLABORADOR')->count(),
                    'active_users' => $agencia->users()->active()->count(),
                    'inactive_users' => $agencia->users()->where('is_active', false)->count(),
                    'agencia' => $agencia,
                    'monthly_revenue' => 0,
                    'units_sold' => 0,
                    'active_inventory' => 0,
                    'pending_events' => 0,
                    'active_leads' => 0,
                    'total_vehicles' => 0,
                    'total_invoices' => 0,
                    'top_vehicles' => [],
                ];
                
                return view('agenciero.dashboard', compact('stats', 'onboarding'));
            }
            
            $vehicles = Vehicle::where('agencia_id', $agencia->id)->get();
            $invoices = Invoice::where('tenant_id', $tenant->id)->get();
            $leads = Lead::where('agencia_id', $agencia->id)->get();
            $events = Event::where('agencia_id', $agencia->id)->get();
            
            // Ingresos mensuales (últimos 30 días)
            $monthlyRevenue = $invoices
                ->filter(fn($inv) => $inv->created_at->diffInDays(now()) <= 30)
                ->sum('total');
            
            // Unidades vendidas (invoices con estado pagado)
            $unitsSold = $invoices->where('status', 'paid')->count();
            
            // Inventario activo
            $activeInventory = $vehicles->where('status', 'available')->count();
            
            // Citas/eventos pendientes
            $pendingEvents = $events->where('status', '!=', 'completed')->count();
            
            // Leads activos
            $activeLeads = $leads->where('status', 'active')->count();
            
            // Vehículos más consultados
            $topVehicles = $vehicles->sortByDesc('views')->take(3);
            
            // Eventos de hoy
            $today = now()->toDateString();
            $todayEvents = $events->filter(function($event) use ($today) {
                return $event->start_time->toDateString() == $today;
            })->sortBy('start_time');
            
            // Próximos eventos (próximos 7 días)
            $upcomingEvents = $events->filter(function($event) {
                return $event->start_time > now() && $event->start_time < now()->addDays(7);
            })->sortBy('start_time')->take(3);
            
            $stats = [
                'total_users' => $agencia->users()->count(),
                'total_agencieros' => $agencia->users()->role('AGENCIERO')->count(),
                'total_colaboradores' => $agencia->users()->role('COLABORADOR')->count(),
                'active_users' => $agencia->users()->active()->count(),
                'inactive_users' => $agencia->users()->where('is_active', false)->count(),
                'agencia' => $agencia,
                'monthly_revenue' => $monthlyRevenue,
                'units_sold' => $unitsSold,
                'active_inventory' => $activeInventory,
                'pending_events' => $pendingEvents,
                'active_leads' => $activeLeads,
                'total_vehicles' => $vehicles->count(),
                'total_invoices' => $invoices->count(),
                'top_vehicles' => $topVehicles,
                'today_events' => $todayEvents,
                'upcoming_events' => $upcomingEvents,
            ];
            
            return view('agenciero.dashboard', compact('stats', 'onboarding'));
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
