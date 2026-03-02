<?php

use Illuminate\Foundation\Inspiring;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\MercadoPagoService;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('subscriptions:simulate-renewal {tenantId} {--status=approved} {--at=} {--reason=} {--ref=}', function (MercadoPagoService $mercadoPagoService) {
    $tenantId = (string) $this->argument('tenantId');
    $status = strtolower((string) $this->option('status'));
    $at = (string) ($this->option('at') ?? '');
    $reason = (string) ($this->option('reason') ?? 'Pago rechazado simulado para QA.');
    $reference = (string) ($this->option('ref') ?? ('sim-' . now()->format('YmdHis')));

    $tenant = Tenant::find($tenantId);

    if (!$tenant) {
        $this->error("Tenant no encontrado: {$tenantId}");
        return 1;
    }

    $subscription = $tenant->subscriptions()->where('payment_method', 'mercadopago')->latest('updated_at')->first();

    if (!$subscription) {
        $this->error('No existe suscripción Mercado Pago para ese tenant.');
        return 1;
    }

    $simulatedAt = now();
    if ($at !== '') {
        try {
            $simulatedAt = now()->setTimeFromTimeString($at);
        } catch (\Throwable $e) {
            $this->error('Formato inválido para --at. Usa HH:MM o HH:MM:SS.');
            return 1;
        }
    }

    $this->info('Ejecutando simulación en ' . $simulatedAt->format('Y-m-d H:i:s'));

    \Carbon\Carbon::setTestNow($simulatedAt);

    try {
        if ($status === 'approved') {
            $updated = $mercadoPagoService->applyApprovedRenewal(
                $tenant,
                (string) $subscription->plan,
                $reference,
                (float) $subscription->amount,
                (string) $subscription->currency
            );

            $this->info('Renovación aprobada simulada.');
            $this->line('Nueva fecha de vencimiento: ' . optional($updated->current_period_end)?->format('Y-m-d H:i:s'));
        } elseif ($status === 'rejected') {
            $mercadoPagoService->applyRejectedRenewal($tenant, $reason, $reference);
            $this->warn('Renovación rechazada simulada. Panel bloqueado hasta reintento.');
        } else {
            $this->error('Estado inválido. Usa --status=approved o --status=rejected');
            return 1;
        }
    } finally {
        \Carbon\Carbon::setTestNow();
    }

    return 0;
})->purpose('Simular renovación de suscripción Mercado Pago hoy (aprobada o rechazada)');

Artisan::command('subscriptions:reconcile-mercadopago {--tenantId=} {--dry-run}', function (MercadoPagoService $mercadoPagoService) {
    $tenantId = (string) ($this->option('tenantId') ?? '');
    $dryRun = (bool) $this->option('dry-run');

    $query = Subscription::query()
        ->where('payment_method', 'mercadopago')
        ->whereNotNull('mercadopago_id');

    if ($tenantId !== '') {
        $query->where('tenant_id', $tenantId);
    }

    $subscriptions = $query->orderBy('id')->get();

    if ($subscriptions->isEmpty()) {
        $this->info('No hay suscripciones Mercado Pago para reconciliar.');
        return 0;
    }

    $this->info('Reconciliando ' . $subscriptions->count() . ' suscripción(es) Mercado Pago...');

    $ok = 0;
    $skipped = 0;
    $errors = 0;

    foreach ($subscriptions as $subscription) {
        try {
            $result = $mercadoPagoService->reconcileSubscriptionFromRemote($subscription, !$dryRun);

            if (($result['result'] ?? '') === 'ok') {
                $ok++;
                $this->line(sprintf(
                    '- #%s tenant=%s remote=%s local=%s%s',
                    $subscription->id,
                    $subscription->tenant_id,
                    $result['remote_status'] ?? 'n/a',
                    $result['local_status'] ?? 'n/a',
                    $dryRun ? ' [dry-run]' : ''
                ));
            } else {
                $skipped++;
                $this->line(sprintf(
                    '- #%s tenant=%s skipped (%s)',
                    $subscription->id,
                    $subscription->tenant_id,
                    $result['reason'] ?? 'unknown'
                ));
            }
        } catch (\Throwable $e) {
            $errors++;
            $this->error(sprintf(
                '- #%s tenant=%s error: %s',
                $subscription->id,
                $subscription->tenant_id,
                $e->getMessage()
            ));
        }
    }

    $this->info("Resumen => ok: {$ok}, skipped: {$skipped}, errors: {$errors}");

    return $errors > 0 ? 1 : 0;
})->purpose('Reconciliar estado local de suscripciones Mercado Pago con estado remoto')->everyTenMinutes();
