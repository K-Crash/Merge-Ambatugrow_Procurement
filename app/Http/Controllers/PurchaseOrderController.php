<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Str;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier', 'items', 'requisition')->orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('name')->get();

        // Calculate dynamic stats
        $stats = [
            'total' => $purchaseOrders->count(),
            'draft' => $purchaseOrders->where('status', 'draft')->count(),
            'sent' => $purchaseOrders->where('status', 'sent')->count(),
            'overdue' => $purchaseOrders->filter(function ($po) {
                return $po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast();
            })->count(),
        ];

        // Fetch matched invoices
        $invoices = \App\Models\Invoice::with('supplier', 'purchaseOrder')
            ->orderBy('received_at', 'desc')
            ->get();

        // Calculate spend data per supplier
        $spendData = $purchaseOrders->groupBy('supplier_id')->map(function ($pos) {
            return [
                'supplier' => $pos->first()->supplier->name ?? 'Unknown',
                'total' => (float)$pos->sum('total'),
            ];
        })->values();

        return view('orders::procurement', compact('purchaseOrders', 'suppliers', 'stats', 'invoices', 'spendData'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $purchaseOrders = PurchaseOrder::with('supplier', 'requisition')->orderBy('created_at', 'desc')->get();

        // Calculate dynamic stats
        $stats = [
            'total' => $purchaseOrders->count(),
            'draft' => $purchaseOrders->where('status', 'draft')->count(),
            'sent' => $purchaseOrders->where('status', 'sent')->count(),
            'overdue' => $purchaseOrders->filter(function ($po) {
                return $po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast();
            })->count(),
        ];

        return view('orders::createpo', compact('suppliers', 'purchaseOrders', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'expected_delivery' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // create PO
        $poNumber = 'PO-'.date('Y').'-'.str_pad((int) (PurchaseOrder::count()+1), 3, '0', STR_PAD_LEFT);
        $po = PurchaseOrder::create([
            'po_number' => $poNumber,
            'supplier_id' => $data['supplier_id'],
            'status' => 'draft',
            'expected_delivery' => $data['expected_delivery'] ?? null,
            'issued_at' => now(),
        ]);

        $total = 0;
        foreach($data['items'] as $it){
            $line = $it['quantity'] * $it['unit_price'];
            $po->items()->create([
                'sku' => $it['sku'] ?? null,
                'name' => $it['name'],
                'quantity' => $it['quantity'],
                'unit_price' => $it['unit_price'],
                'line_total' => $line,
            ]);
            $total += $line;
        }

        $po->total = $total;
        $po->save();

        return redirect()->route('procurement.home')->with('status','PO created');
    }

    public function send(PurchaseOrder $purchaseOrder)
    {
        // mark as sent and set issued_at
        $purchaseOrder->status = 'sent';
        $purchaseOrder->issued_at = now();
        $purchaseOrder->save();

        // For now, just log/send an email stub (Mail config required to actually send)
        \Log::info('PO sent', ['po' => $purchaseOrder->po_number, 'supplier' => $purchaseOrder->supplier->name]);

        return back()->with('status','PO marked as sent');
    }

    public function updateStatus(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate(['status' => 'required|string']);
        $purchaseOrder->status = $request->input('status');
        $purchaseOrder->save();
        return back()->with('status','Status updated');
    }

    public function matchInvoice(Request $request)
    {
        // naive match: find PO by po_number and associate invoice
        $request->validate(['po_number'=>'required','invoice_number'=>'required','amount'=>'required|numeric']);
        $po = PurchaseOrder::where('po_number',$request->po_number)->first();
        if(!$po) return back()->with('error','PO not found');

        // create invoice
        $inv = \App\Models\Invoice::create([
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $po->supplier_id,
            'purchase_order_id' => $po->id,
            'amount' => $request->amount,
            'received_at' => now(),
        ]);

        return back()->with('status','Invoice matched to PO');
    }
}
