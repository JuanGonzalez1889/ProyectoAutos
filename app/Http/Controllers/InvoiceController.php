<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $tenant = $invoice->tenant;
        $domain = $tenant ? $tenant->getPrimaryDomain() : null;
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'tenant', 'domain'));
        $filename = 'Factura_' . $invoice->invoice_number . '.pdf';
        return $pdf->download($filename);
    }
}
