<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Vista de vehículos para preview desde admin
     */
    public function adminIndex(Request $request)
    {
        $user = auth()->user();
        $tenant = $user->tenant ?? null;
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }
        $settings = $tenant->settings ?? null;
        $vehicles = Vehicle::where('is_active', true)
            ->where('tenant_id', $tenant->id)
            ->get();
        // Selección dinámica de vista según template
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        $view = 'public.vehiculos.index-' . $template;
        if (!view()->exists($view)) {
            $view = 'public.vehiculos.index'; // fallback minimalista
        }
        return view($view, compact('vehicles', 'settings', 'tenant'));
    }

    /**
     * Vista de detalle de vehículo para preview desde admin
     */
    public function adminShow(Request $request, Vehicle $vehicle)
    {
        $user = auth()->user();
        $tenant = $user->tenant ?? null;
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }
        $settings = $tenant->settings ?? null;
        // Validar que el vehículo pertenezca al tenant
        if ($vehicle->tenant_id !== $tenant->id) {
            abort(404, 'Vehículo no encontrado para tu tenant');
        }
        // Selección dinámica de vista según template
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        $view = 'public.vehiculos.show-' . $template;
        if (!view()->exists($view)) {
            $view = 'public.vehiculos.show'; // fallback minimalista
        }
        return view($view, compact('vehicle', 'settings', 'tenant'));
    }

    public function index(Request $request)
    {
        // Obtener dominio actual
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);

        // Si es localhost o 127.0.0.1, usar el primer tenant para desarrollo
        if (in_array($domain, ['localhost', '127.0.0.1'])) {
            $tenant = \App\Models\Tenant::first();
            if (!$tenant) abort(404, 'No hay tenants en la base de datos.');
            $settings = $tenant->settings ?? null;
        } else {
            // Buscar si hay un registro de dominio
            $domainRecord = \App\Models\Domain::where('domain', $domain)->first();
            if (!$domainRecord || !$domainRecord->tenant) {
                abort(404, 'Dominio no encontrado.');
            }
            $tenant = $domainRecord->tenant;
            $settings = $tenant->settings ?? null;
        }

        $vehicles = Vehicle::where('is_active', true)
            ->where('tenant_id', $tenant->id)
            ->get();

        // Selección dinámica de vista según template
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        $view = 'public.vehiculos.index-' . $template;
        if (!view()->exists($view)) {
            $view = 'public.vehiculos.index'; // fallback minimalista
        }
        return view($view, compact('vehicles', 'settings', 'tenant'));
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        // Obtener dominio actual
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);

        // Si es localhost o 127.0.0.1, usar el primer tenant para desarrollo
        if (in_array($domain, ['localhost', '127.0.0.1'])) {
            $tenant = \App\Models\Tenant::first();
            if (!$tenant) abort(404, 'No hay tenants en la base de datos.');
            $settings = $tenant->settings ?? null;
        } else {
            // Buscar si hay un registro de dominio
            $domainRecord = \App\Models\Domain::where('domain', $domain)->first();
            if (!$domainRecord || !$domainRecord->tenant) {
                abort(404, 'Dominio no encontrado.');
            }
            $tenant = $domainRecord->tenant;
            $settings = $tenant->settings ?? null;
        }

        // Selección dinámica de vista según template
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        $view = 'public.vehiculos.show-' . $template;
        if (!view()->exists($view)) {
            $view = 'public.vehiculos.show'; // fallback minimalista
        }
        return view($view, compact('vehicle', 'settings', 'tenant'));
    }
}
