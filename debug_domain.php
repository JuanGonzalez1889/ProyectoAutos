<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$domain = \App\Models\Domain::where('domain', 'juancitoautos.misaas.com')->first();
if ($domain) {
  echo 'Domain found: ' . $domain->domain . PHP_EOL;
  echo 'Tenant ID: ' . $domain->tenant_id . PHP_EOL;
  $tenant = $domain->tenant;
  echo 'Tenant: ' . $tenant->name . PHP_EOL;
  $vehicles = \App\Models\Vehicle::where('tenant_id', $tenant->id)->get();
  echo 'Total vehicles: ' . $vehicles->count() . PHP_EOL;
  $published = \App\Models\Vehicle::where('tenant_id', $tenant->id)->where('status', 'published')->get();
  echo 'Published vehicles: ' . $published->count() . PHP_EOL;
  $settings = $tenant->settings;
  echo 'Has settings: ' . ($settings ? 'Yes' : 'No') . PHP_EOL;
  if ($settings) echo 'Template: ' . ($settings->template ?? 'null') . PHP_EOL;
} else {
  echo 'Domain not found' . PHP_EOL;
}
