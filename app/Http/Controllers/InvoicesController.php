<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function getInvoices()
    {
        $invoices = Invoice::orderBy('id', 'DESC')->paninate(Data::$perPage);
        return view('layouts.invoices.invoices')->with(['invoices' => $invoices]);
    }

    public function getInvoice($id = 0)
    {
        $invoice = [];
        if ($id != 0)
            $invoice = Invoice::where('id', $id)->first();
        return !$invoice ? view('layouts.empty') :
            view('layouts.invoices.invoice')->with(['id' => $id, 'invoice' => $invoice]);
    }
}
