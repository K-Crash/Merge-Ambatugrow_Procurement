<?php

namespace App\Http\Controllers;

use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatchingController extends Controller
{
    private function getMockData()
    {
        return [
            [
                'id' => 'mock-1',
                'po_number' => 'PO-2024-00041',
                'po_date' => '14 Jun 2024',
                'supplier' => 'Savanna Grain Co.',
                'commodity' => 'White Maize',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => 'GRN-2024-03201',
                'grn_date' => '18 Jun 2024',
                'invoice_number' => 'INV-SG-8821',
                'invoice_date' => '19 Jun 2024',
                'po_amount' => 204500.00,
                'invoice_amount' => 204500.00,
                'variance' => 0.0,
                'status' => 'Matched',
                'supplier_initials' => 'SG',
                'payment_approvable' => true,
                'discrepancies' => [],
                'matched_fields' => ['PO Number: PO-2024-00041', 'Supplier: Savanna Grain Co.', 'Quantities: 100/100 Accepted', 'Amounts Reconciled'],
                'received_by' => 'Central Depot Receiving',
                'received_at' => '2024-06-18 14:30:00',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'id' => 'mock-2',
                'po_number' => 'PO-2024-00058',
                'po_date' => '15 Jun 2024',
                'supplier' => 'Highveld Agri Traders',
                'commodity' => 'Soybeans',
                'payment_terms' => 'Net 45',
                'warehouse' => 'Bulawayo Grain Silo',
                'grn_number' => 'GRN-2024-03304',
                'grn_date' => '20 Jun 2024',
                'invoice_number' => 'INV-HA-4412',
                'invoice_date' => '21 Jun 2024',
                'po_amount' => 520000.00,
                'invoice_amount' => 520000.00,
                'variance' => -52000.00,
                'status' => 'Mismatch Detected',
                'supplier_initials' => 'HA',
                'payment_approvable' => false,
                'discrepancies' => ['Quantity Mismatch: Accepted quantity (900 bags) is less than PO ordered quantity (1000 bags).'],
                'matched_fields' => ['PO Number: PO-2024-00058', 'Supplier: Highveld Agri Traders'],
                'received_by' => 'Bulawayo Receiving Bay',
                'received_at' => '2024-06-20 09:15:00',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'id' => 'mock-3',
                'po_number' => 'PO-2024-00072',
                'po_date' => '17 Jun 2024',
                'supplier' => 'Delta Farm Supplies',
                'commodity' => 'Wheat',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => 'GRN-2024-03318',
                'grn_date' => '22 Jun 2024',
                'invoice_number' => null,
                'invoice_date' => null,
                'po_amount' => 153750.00,
                'invoice_amount' => 0.0,
                'variance' => 0.0,
                'status' => 'Pending Invoice',
                'supplier_initials' => 'DF',
                'payment_approvable' => false,
                'discrepancies' => ['Supplier Invoice not found. Matching cannot be completed until all required documents are available.'],
                'matched_fields' => ['PO Number: PO-2024-00072', 'Supplier: Delta Farm Supplies', 'Goods Received'],
                'received_by' => 'Harare Receiving Bay',
                'received_at' => '2024-06-22 11:00:00',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'id' => 'mock-4',
                'po_number' => 'PO-2024-00033',
                'po_date' => '18 Jun 2024',
                'supplier' => 'Zambezi Valley Farms',
                'commodity' => 'Cotton Seed',
                'payment_terms' => 'Net 15',
                'warehouse' => 'Gweru Depot',
                'grn_number' => null,
                'grn_date' => null,
                'invoice_number' => 'INV-ZV-1109',
                'invoice_date' => '23 Jun 2024',
                'po_amount' => 347200.00,
                'invoice_amount' => 347200.00,
                'variance' => 0.0,
                'status' => 'Pending Receipt',
                'supplier_initials' => 'ZV',
                'payment_approvable' => false,
                'discrepancies' => ['Delivery Receipt (GRN) not found. Matching cannot be completed until all required documents are available.'],
                'matched_fields' => ['PO Number: PO-2024-00033', 'Supplier: Zambezi Valley Farms', 'Invoice Received'],
                'received_by' => null,
                'received_at' => null,
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'id' => 'mock-5',
                'po_number' => 'PO-2024-00081',
                'po_date' => '19 Jun 2024',
                'supplier' => 'Pioneer Seeds Ltd.',
                'commodity' => 'Sunflower',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Mutare Logistics Hub',
                'grn_number' => 'GRN-2024-03337',
                'grn_date' => '24 Jun 2024',
                'invoice_number' => 'INV-PS-7734',
                'invoice_date' => '24 Jun 2024',
                'po_amount' => 412000.00,
                'invoice_amount' => 432500.00,
                'variance' => 20500.00,
                'status' => 'Mismatch Detected',
                'supplier_initials' => 'PS',
                'payment_approvable' => false,
                'discrepancies' => [
                    'Total Amount Mismatch: Invoice Amount (₱432,500.00) exceeds PO Value (₱412,000.00) by ₱20,500.00.',
                    'Unit Price Mismatch: Invoice unit price differs from approved PO price.'
                ],
                'matched_fields' => ['PO Number: PO-2024-00081', 'Supplier: Pioneer Seeds Ltd.'],
                'received_by' => 'Mutare Logistics Team',
                'received_at' => '2024-06-24 16:20:00',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'id' => 'mock-6',
                'po_number' => 'PO-2024-00002',
                'po_date' => '20 Jun 2024',
                'supplier' => 'Savanna Grain Co.',
                'commodity' => 'Yellow Maize',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => 'GRN-2024-03261',
                'grn_date' => '25 Jun 2024',
                'invoice_number' => 'INV-SG-8839',
                'invoice_date' => '25 Jun 2024',
                'po_amount' => 170400.00,
                'invoice_amount' => 170400.00,
                'variance' => 0.0,
                'status' => 'Approved for Payment',
                'supplier_initials' => 'SG',
                'payment_approvable' => true,
                'discrepancies' => [],
                'matched_fields' => ['PO Number: PO-2024-00002', 'Supplier: Savanna Grain Co.', 'Amounts Reconciled'],
                'received_by' => 'Harare Receiving Bay',
                'received_at' => '2024-06-25 10:00:00',
                'approved_by' => 'System Admin',
                'approved_at' => '2024-06-26 09:30:00',
            ],
        ];
    }

    private function getDatabaseRecords()
    {
        $dbRecords = [];

        $drs = DeliveryReceipt::with(['purchaseOrder.supplier', 'purchaseOrder.items'])->get();
        foreach ($drs as $dr) {
            $po = $dr->purchaseOrder;
            if (!$po) continue;

            $inv = Invoice::where('purchase_order_id', $po->id)->first();
            $poAmount = (float) $po->total;
            $invAmount = $inv ? (float) $inv->amount : 0.0;

            $itemsData = is_array($dr->items) ? $dr->items : json_decode($dr->items ?? '[]', true);
            $lines = $itemsData['lines'] ?? [];
            $grnAcceptedTotal = $itemsData['accepted_total'] ?? 0;
            if (!$grnAcceptedTotal && !empty($lines)) {
                foreach ($lines as $l) {
                    $grnAcceptedTotal += ((float)($l['qty_accepted'] ?? 0) * (float)($l['unit_price'] ?? 0));
                }
            }

            $discrepancies = [];
            $matchedFields = ['PO Number: ' . $po->po_number];
            
            $supplierName = $po->supplier ? ($po->supplier->supplier_name ?? $po->supplier->name ?? 'Vendor') : 'Vendor';
            $matchedFields[] = 'Supplier: ' . $supplierName;

            if ($inv) {
                $variance = $invAmount - $poAmount;
                if (abs($variance) < 0.01 && abs($grnAcceptedTotal - $poAmount) < 0.01) {
                    $status = ($po->status === 'approved' || $po->status === 'received') ? 'Matched' : 'Approved for Payment';
                    $paymentApprovable = true;
                    $matchedFields[] = 'Amounts Fully Reconciled';
                    $matchedFields[] = 'Quantities & Prices Matched';
                } else if ($variance > 0) {
                    $status = 'Mismatch Detected';
                    $paymentApprovable = false;
                    $discrepancies[] = 'Total Amount Mismatch: Invoice Amount (₱' . number_format($invAmount, 2) . ') exceeds PO Value (₱' . number_format($poAmount, 2) . ') by ₱' . number_format($variance, 2) . '.';
                } else {
                    $status = 'Mismatch Detected';
                    $paymentApprovable = false;
                    $discrepancies[] = 'Quantity/Amount Partial Mismatch: Delivered/Accepted total (₱' . number_format($grnAcceptedTotal, 2) . ') differs from PO Value (₱' . number_format($poAmount, 2) . ').';
                }
            } else {
                $status = 'Pending Invoice';
                $paymentApprovable = false;
                $discrepancies[] = 'Supplier Invoice not found. Matching cannot be completed until all required documents are available.';
            }

            $words = explode(' ', $supplierName);
            $initials = strtoupper(substr($words[0] ?? 'V', 0, 1) . substr($words[1] ?? '', 0, 1));

            $dbRecords[] = [
                'id' => $dr->id,
                'po_number' => $po->po_number,
                'po_id' => $po->id,
                'po_date' => $po->created_at ? $po->created_at->format('d M Y') : now()->format('d M Y'),
                'supplier' => $supplierName,
                'commodity' => !empty($lines) ? ($lines[0]['name'] ?? 'Agricultural Goods') : 'Goods Receipt',
                'payment_terms' => 'Net 30',
                'warehouse' => $itemsData['location'] ?? 'Central Warehouse',
                'grn_number' => $dr->dr_number,
                'grn_date' => $dr->received_at ? Carbon::parse($dr->received_at)->format('d M Y') : now()->format('d M Y'),
                'invoice_number' => $inv ? $inv->invoice_number : null,
                'invoice_date' => $inv && $inv->received_at ? Carbon::parse($inv->received_at)->format('d M Y') : null,
                'po_amount' => $poAmount,
                'invoice_amount' => $invAmount,
                'variance' => $inv ? ($invAmount - $poAmount) : 0.0,
                'status' => $status,
                'supplier_initials' => $initials ?: 'GR',
                'payment_approvable' => $paymentApprovable,
                'discrepancies' => $discrepancies,
                'matched_fields' => $matchedFields,
                'received_by' => $itemsData['received_by'] ?? 'Purchasing Agent',
                'received_at' => $dr->received_at ? Carbon::parse($dr->received_at)->format('Y-m-d H:i:s') : null,
                'approved_by' => $itemsData['approved_by'] ?? null,
                'approved_at' => $itemsData['approved_at'] ?? null,
            ];
        }

        // Standalone Invoices linked to POs
        $invoicesWithoutDr = Invoice::with(['purchaseOrder.supplier'])
            ->whereNotNull('purchase_order_id')
            ->whereNotIn('purchase_order_id', array_column($dbRecords, 'po_id'))
            ->get();

        foreach ($invoicesWithoutDr as $inv) {
            $po = $inv->purchaseOrder;
            if (!$po) continue;

            $supplierName = $po->supplier ? ($po->supplier->supplier_name ?? $po->supplier->name ?? 'Vendor') : 'Vendor';
            $words = explode(' ', $supplierName);
            $initials = strtoupper(substr($words[0] ?? 'V', 0, 1) . substr($words[1] ?? '', 0, 1));

            $dbRecords[] = [
                'id' => 'inv-' . $inv->id,
                'po_number' => $po->po_number,
                'po_id' => $po->id,
                'po_date' => $po->created_at ? $po->created_at->format('d M Y') : now()->format('d M Y'),
                'supplier' => $supplierName,
                'commodity' => 'Vendor Invoice',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => null,
                'grn_date' => null,
                'invoice_number' => $inv->invoice_number,
                'invoice_date' => $inv->received_at ? Carbon::parse($inv->received_at)->format('d M Y') : now()->format('d M Y'),
                'po_amount' => (float)$po->total,
                'invoice_amount' => (float)$inv->amount,
                'variance' => (float)($inv->amount - $po->total),
                'status' => 'Pending Receipt',
                'supplier_initials' => $initials ?: 'INV',
                'payment_approvable' => false,
                'discrepancies' => ['Delivery Receipt (GRN) not found. Matching cannot be completed until all required documents are available.'],
                'matched_fields' => ['PO Number: ' . $po->po_number, 'Supplier: ' . $supplierName],
                'received_by' => null,
                'received_at' => null,
                'approved_by' => null,
                'approved_at' => null,
            ];
        }

        // Standalone POs without DR or Invoice yet
        $existingPoIds = array_column($dbRecords, 'po_id');
        $posWithoutDocs = PurchaseOrder::with(['supplier'])
            ->whereNotIn('id', array_filter($existingPoIds))
            ->get();

        foreach ($posWithoutDocs as $po) {
            $supplierName = $po->supplier ? ($po->supplier->supplier_name ?? $po->supplier->name ?? 'Vendor') : 'Vendor';
            $words = explode(' ', $supplierName);
            $initials = strtoupper(substr($words[0] ?? 'V', 0, 1) . substr($words[1] ?? '', 0, 1));

            $dbRecords[] = [
                'id' => 'po-' . $po->id,
                'po_number' => $po->po_number,
                'po_id' => $po->id,
                'po_date' => $po->created_at ? $po->created_at->format('d M Y') : now()->format('d M Y'),
                'supplier' => $supplierName,
                'commodity' => 'Purchase Order',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => null,
                'grn_date' => null,
                'invoice_number' => null,
                'invoice_date' => null,
                'po_amount' => (float)$po->total,
                'invoice_amount' => 0.0,
                'variance' => 0.0,
                'status' => 'Awaiting Delivery',
                'supplier_initials' => $initials ?: 'PO',
                'payment_approvable' => false,
                'discrepancies' => [
                    'Delivery Receipt (GRN) not found.',
                    'Supplier Invoice not found.',
                    'Matching cannot be completed until all required documents are available.'
                ],
                'matched_fields' => ['PO Number: ' . $po->po_number, 'Supplier: ' . $supplierName],
                'received_by' => null,
                'received_at' => null,
                'approved_by' => null,
                'approved_at' => null,
            ];
        }

        return $dbRecords;
    }

    private function getAvailablePos()
    {
        $pos = PurchaseOrder::with(['supplier', 'items'])->orderBy('created_at', 'desc')->get();
        $list = [];

        foreach ($pos as $po) {
            $supplierName = $po->supplier ? ($po->supplier->supplier_name ?? $po->supplier->name ?? 'Supplier') : 'Supplier';
            $list[] = [
                'id' => $po->id,
                'po_number' => $po->po_number,
                'supplier' => $supplierName,
                'status' => $po->status,
                'total' => (float)$po->total,
                'items' => $po->items->map(function ($it) {
                    return [
                        'id' => $it->id,
                        'name' => $it->name,
                        'qty' => (float)$it->quantity,
                        'unit_price' => (float)$it->unit_price,
                        'line_total' => (float)$it->line_total,
                    ];
                })->toArray(),
            ];
        }

        $samplePos = [
            ['id' => 1024, 'po_number' => 'PO-1024', 'supplier' => 'ABC Farms', 'total' => 501166.00],
            ['id' => 998, 'po_number' => 'PO-0998', 'supplier' => 'ABC Farms', 'total' => 144522.00],
            ['id' => 1017, 'po_number' => 'PO-1017', 'supplier' => 'Green Harvest', 'total' => 317232.00],
            ['id' => 921, 'po_number' => 'PO-0921', 'supplier' => 'Green Harvest', 'total' => 94168.48],
            ['id' => 1004, 'po_number' => 'PO-1004', 'supplier' => 'Fresh Mango Co.', 'total' => 116484.48],
        ];

        foreach ($samplePos as $sample) {
            if (!collect($list)->pluck('po_number')->contains($sample['po_number'])) {
                $list[] = [
                    'id' => $sample['id'],
                    'po_number' => $sample['po_number'],
                    'supplier' => $sample['supplier'],
                    'status' => 'delivered',
                    'total' => $sample['total'],
                    'items' => [
                        ['id' => 1, 'name' => 'Agricultural Produce Item', 'qty' => 100, 'unit_price' => 25.00, 'line_total' => 2500.00]
                    ],
                ];
            }
        }

        return $list;
    }

    public function index(Request $request)
    {
        $statusFilter = $request->input('status', 'All');
        $searchQuery = $request->input('search');
        $supplierFilter = $request->input('supplier');
        $sortBy = $request->input('sort_by', 'date_desc');

        $warehouseFilter = $request->input('warehouse');
        $commodityFilter = $request->input('commodity');
        $varianceFilter = $request->input('variance_type');
        $minAmount = $request->input('min_amount');
        $maxAmount = $request->input('max_amount');

        $dbRecords = $this->getDatabaseRecords();
        $mockRecords = $this->getMockData();

        $allData = array_merge($dbRecords, $mockRecords);
        $filteredData = $allData;

        if ($statusFilter && $statusFilter !== 'All') {
            $filteredData = array_filter($filteredData, function ($item) use ($statusFilter) {
                return strtolower($item['status']) === strtolower($statusFilter);
            });
        }

        if ($supplierFilter && $supplierFilter !== 'All Suppliers') {
            $filteredData = array_filter($filteredData, function ($item) use ($supplierFilter) {
                return $item['supplier'] === $supplierFilter;
            });
        }

        if ($searchQuery) {
            $searchQuery = strtolower(trim($searchQuery));
            $filteredData = array_filter($filteredData, function ($item) use ($searchQuery) {
                return str_contains(strtolower($item['po_number']), $searchQuery) ||
                       str_contains(strtolower($item['supplier']), $searchQuery) ||
                       str_contains(strtolower($item['commodity']), $searchQuery) ||
                       str_contains(strtolower($item['grn_number'] ?? ''), $searchQuery) ||
                       str_contains(strtolower($item['invoice_number'] ?? ''), $searchQuery);
            });
        }

        if ($warehouseFilter && $warehouseFilter !== 'All Warehouses') {
            $filteredData = array_filter($filteredData, function ($item) use ($warehouseFilter) {
                return strtolower($item['warehouse'] ?? '') === strtolower($warehouseFilter);
            });
        }

        if ($commodityFilter) {
            $commodityFilter = strtolower($commodityFilter);
            $filteredData = array_filter($filteredData, function ($item) use ($commodityFilter) {
                return str_contains(strtolower($item['commodity'] ?? ''), $commodityFilter);
            });
        }

        if ($varianceFilter) {
            if ($varianceFilter === 'has_variance') {
                $filteredData = array_filter($filteredData, fn($item) => abs($item['variance']) > 0);
            } else if ($varianceFilter === 'no_variance') {
                $filteredData = array_filter($filteredData, fn($item) => abs($item['variance']) == 0);
            }
        }

        if ($minAmount !== null && $minAmount !== '') {
            $filteredData = array_filter($filteredData, fn($item) => $item['po_amount'] >= (float)$minAmount);
        }
        if ($maxAmount !== null && $maxAmount !== '') {
            $filteredData = array_filter($filteredData, fn($item) => $item['po_amount'] <= (float)$maxAmount);
        }

        usort($filteredData, function ($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'date_asc':
                    return strtotime($a['po_date']) <=> strtotime($b['po_date']);
                case 'po_asc':
                    return strcmp($a['po_number'], $b['po_number']);
                case 'po_desc':
                    return strcmp($b['po_number'], $a['po_number']);
                case 'amount_desc':
                    return $b['po_amount'] <=> $a['po_amount'];
                case 'amount_asc':
                    return $a['po_amount'] <=> $b['po_amount'];
                case 'variance_desc':
                    return abs($b['variance']) <=> abs($a['variance']);
                case 'status':
                    return strcmp($a['status'], $b['status']);
                case 'date_desc':
                default:
                    return strtotime($b['po_date']) <=> strtotime($a['po_date']);
            }
        });

        $suppliersList = array_unique(array_column($allData, 'supplier'));
        sort($suppliersList);

        $selectedPo = $request->input('selected_po');
        $selectedRecord = null;
        if ($selectedPo) {
            foreach ($allData as $item) {
                $itemKey = $item['po_number'] . '-' . str_replace(' ', '', $item['supplier']);
                if ($itemKey === $selectedPo || $item['po_number'] === $selectedPo) {
                    $selectedRecord = $item;
                    break;
                }
            }
        }
        
        if (!$selectedRecord && !empty($filteredData)) {
            $selectedRecord = reset($filteredData);
        }

        $availablePos = $this->getAvailablePos();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'records' => array_values($filteredData),
                'count' => count($filteredData),
                'selected' => $selectedRecord,
                'availablePos' => $availablePos,
            ]);
        }

        return view('grim::dashboard', [
            'records' => array_values($filteredData),
            'allRecords' => $allData,
            'suppliers' => $suppliersList,
            'selectedRecord' => $selectedRecord,
            'currentStatus' => $statusFilter,
            'currentSearch' => $searchQuery,
            'currentSupplier' => $supplierFilter,
            'currentSort' => $sortBy,
            'availablePos' => $availablePos,
        ]);
    }

    public function getPoItems($purchaseOrder)
    {
        $po = PurchaseOrder::with(['items', 'supplier'])->find($purchaseOrder);
        if (!$po) {
            $po = PurchaseOrder::with(['items', 'supplier'])->where('po_number', $purchaseOrder)->first();
        }

        if (!$po) {
            $available = collect($this->getAvailablePos())->firstWhere('po_number', $purchaseOrder);
            if ($available) {
                return response()->json([
                    'id' => $available['id'],
                    'po_number' => $available['po_number'],
                    'supplier' => $available['supplier'],
                    'total' => $available['total'],
                    'items' => $available['items'],
                ]);
            }
            return response()->json(['error' => 'Purchase Order not found'], 404);
        }

        $items = $po->items->map(function ($it) {
            return [
                'id' => $it->id,
                'name' => $it->name,
                'qty' => (float)$it->quantity,
                'unit_price' => (float)$it->unit_price,
                'line_total' => (float)$it->line_total,
            ];
        });

        $supplierName = $po->supplier ? ($po->supplier->supplier_name ?? $po->supplier->name ?? 'Supplier') : 'Supplier';

        return response()->json([
            'id' => $po->id,
            'po_number' => $po->po_number,
            'supplier' => $supplierName,
            'total' => (float)$po->total,
            'items' => $items,
        ]);
    }

    // Requirement 1 & 5: Record Goods Receipt
    public function storeGrn(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|string',
            'grn_number' => 'required|string',
            'received_at' => 'required',
            'receiving_location' => 'nullable|string',
            'invoice_number' => 'nullable|string',
            'invoice_amount' => 'nullable|numeric',
            'invoice_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'matching_notes' => 'nullable|string',
            'lines' => 'nullable|array',
        ]);

        // Prevent duplicate GRN number
        if (DeliveryReceipt::where('dr_number', $validated['grn_number'])->exists()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate Receipt Record: GRN number ' . $validated['grn_number'] . ' has already been recorded.',
                ], 422);
            }
        }

        $po = PurchaseOrder::where('po_number', $validated['po_number'])->first();
        if (!$po) {
            $supplier = Supplier::first();
            $po = PurchaseOrder::create([
                'po_number' => $validated['po_number'],
                'supplier_id' => $supplier ? $supplier->id : 1,
                'status' => 'received',
                'total' => 0,
                'issued_at' => now(),
            ]);
        }

        $lines = $validated['lines'] ?? [];
        $acceptedTotal = 0;
        $qtyDiscrepancies = [];

        foreach ($lines as $line) {
            $qtyRec = (float)($line['qty_received'] ?? 0);
            $qtyAcc = (float)($line['qty_accepted'] ?? $qtyRec);
            $price = (float)($line['unit_price'] ?? 0);
            $acceptedTotal += ($qtyAcc * $price);

            if ($qtyAcc < $qtyRec) {
                $qtyDiscrepancies[] = "Item {$line['name']}: Accepted {$qtyAcc} of {$qtyRec} received (" . ($line['condition'] ?? 'Damaged') . ").";
            }
        }

        $receivedBy = Auth::check() ? Auth::user()->name : 'Purchasing Agent';

        $dr = DeliveryReceipt::create([
            'dr_number' => $validated['grn_number'],
            'purchase_order_id' => $po->id,
            'received_at' => Carbon::parse($validated['received_at']),
            'items' => [
                'location' => $validated['receiving_location'] ?? 'Warehouse',
                'notes' => $validated['matching_notes'] ?? '',
                'lines' => $lines,
                'accepted_total' => $acceptedTotal,
                'received_by' => $receivedBy,
            ],
        ]);

        $inv = null;
        if (!empty($validated['invoice_number'])) {
            $invAmount = (float)($validated['invoice_amount'] ?? $acceptedTotal);
            $inv = Invoice::create([
                'invoice_number' => $validated['invoice_number'],
                'supplier_id' => $po->supplier_id,
                'purchase_order_id' => $po->id,
                'amount' => $invAmount,
                'received_at' => !empty($validated['invoice_date']) ? Carbon::parse($validated['invoice_date']) : now(),
            ]);
        }

        $poTotal = (float)$po->total;
        if ($poTotal == 0 && $acceptedTotal > 0) {
            $poTotal = $acceptedTotal;
            $po->total = $poTotal;
            $po->save();
        }

        $variance = 0;
        $discrepancies = array_merge([], $qtyDiscrepancies);
        if ($inv) {
            $variance = (float)$inv->amount - $poTotal;
            if (abs($variance) < 0.01 && empty($discrepancies)) {
                $status = 'Matched';
                $po->status = 'received';
                $po->save();
            } else if ($variance > 0) {
                $status = 'Mismatch Detected';
                $discrepancies[] = 'Total Amount Mismatch: Invoice Amount (₱' . number_format($inv->amount, 2) . ') exceeds PO Value (₱' . number_format($poTotal, 2) . ') by ₱' . number_format($variance, 2) . '.';
            } else {
                $status = 'Mismatch Detected';
                $discrepancies[] = 'Variance/Partial Match: Invoice Amount (₱' . number_format($inv->amount, 2) . ') differs from PO Value (₱' . number_format($poTotal, 2) . ').';
            }
        } else {
            $status = 'Pending Invoice';
            $discrepancies[] = 'Supplier Invoice not found. Matching cannot be completed until all required documents are available.';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Goods Receipt recorded and 3-way matched successfully!',
                'grn_number' => $dr->dr_number,
                'status' => $status,
                'variance' => $variance,
                'discrepancies' => $discrepancies,
                'received_by' => $receivedBy,
            ]);
        }

        return redirect()->route('matching.index')->with('status', 'Goods Receipt recorded successfully! Status: ' . $status);
    }

    // Requirement 2 & 5: Run 3-Way Matching Action
    public function runThreeWayMatching(Request $request)
    {
        $poNumber = $request->input('po_number');
        if (!$poNumber) {
            return response()->json(['success' => false, 'message' => 'Purchase Order number is required.'], 422);
        }

        $allData = array_merge($this->getDatabaseRecords(), $this->getMockData());
        $record = collect($allData)->firstWhere('po_number', $poNumber);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase Order ' . $poNumber . ' not found.',
                'discrepancies' => ['Purchase Order not found in matching database.']
            ], 404);
        }

        $discrepancies = [];
        $matchedFields = ['PO Number: ' . $record['po_number'], 'Supplier: ' . $record['supplier']];

        if (!$record['grn_number']) {
            $discrepancies[] = 'Delivery Receipt (GRN) not found. Matching cannot be completed until all required documents are available.';
        } else {
            $matchedFields[] = 'Delivery Receipt: ' . $record['grn_number'];
        }

        if (!$record['invoice_number']) {
            $discrepancies[] = 'Supplier Invoice not found. Matching cannot be completed until all required documents are available.';
        } else {
            $matchedFields[] = 'Supplier Invoice: ' . $record['invoice_number'];
        }

        if ($record['invoice_number'] && $record['grn_number']) {
            if (abs($record['variance']) < 0.01) {
                $status = 'Matched';
                $paymentApprovable = true;
                $matchedFields[] = 'Amounts Fully Reconciled (₱' . number_format($record['po_amount'], 2) . ')';
                $matchedFields[] = 'Supplier & Document IDs Matched';
            } else {
                $status = 'Mismatch Detected';
                $paymentApprovable = false;
                if ($record['variance'] > 0) {
                    $discrepancies[] = 'Total Amount Mismatch: Invoice Amount (₱' . number_format($record['invoice_amount'], 2) . ') exceeds PO Value (₱' . number_format($record['po_amount'], 2) . ') by ₱' . number_format($record['variance'], 2) . '.';
                } else {
                    $discrepancies[] = 'Quantity / Amount Partial Mismatch: Invoice Amount (₱' . number_format($record['invoice_amount'], 2) . ') is less than PO Value (₱' . number_format($record['po_amount'], 2) . ').';
                }
            }
        } else {
            $status = $record['status'];
            $paymentApprovable = false;
        }

        return response()->json([
            'success' => true,
            'po_number' => $record['po_number'],
            'status' => $status,
            'payment_approvable' => $paymentApprovable,
            'discrepancies' => $discrepancies,
            'matched_fields' => $matchedFields,
            'message' => empty($discrepancies) 
                ? '3-Way Matching Successful! All documents, quantities, and amounts match.' 
                : '3-Way Matching Executed: Discrepancies/missing documents detected.'
        ]);
    }

    // Requirement 7: Get Matching Details for Modal
    public function getMatchingDetails($poNumber)
    {
        $allData = array_merge($this->getDatabaseRecords(), $this->getMockData());
        $record = collect($allData)->firstWhere('po_number', $poNumber);

        if (!$record) {
            return response()->json(['error' => 'Matching record not found'], 404);
        }

        return response()->json([
            'po_number' => $record['po_number'],
            'po_date' => $record['po_date'],
            'supplier' => $record['supplier'],
            'commodity' => $record['commodity'],
            'warehouse' => $record['warehouse'],
            'payment_terms' => $record['payment_terms'],
            'po_amount' => $record['po_amount'],
            'grn_number' => $record['grn_number'],
            'grn_date' => $record['grn_date'],
            'invoice_number' => $record['invoice_number'],
            'invoice_date' => $record['invoice_date'],
            'invoice_amount' => $record['invoice_amount'],
            'variance' => $record['variance'],
            'status' => $record['status'],
            'payment_approvable' => $record['payment_approvable'] ?? ($record['status'] === 'Matched'),
            'discrepancies' => $record['discrepancies'] ?? [],
            'matched_fields' => $record['matched_fields'] ?? [],
            'received_by' => $record['received_by'] ?? 'Warehouse Receiver',
            'approved_by' => $record['approved_by'] ?? null,
            'approved_at' => $record['approved_at'] ?? null,
        ]);
    }

    // Requirement 4: Payment Approval Validation
    public function approvePayment($id)
    {
        $allData = array_merge($this->getDatabaseRecords(), $this->getMockData());
        
        $targetRecord = null;
        foreach ($allData as $r) {
            if ((string)$r['id'] === (string)$id || $r['po_number'] === $id) {
                $targetRecord = $r;
                break;
            }
        }

        // Requirement 4 & 8: Validate payment approval
        if ($targetRecord && !in_array($targetRecord['status'], ['Matched', 'Approved for Payment'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Payment cannot be approved because the transaction contains unresolved matching issues or missing required documents.',
                'discrepancies' => $targetRecord['discrepancies'] ?? ['Transaction status is not Matched.'],
            ], 422);
        }

        $dr = DeliveryReceipt::find($id);
        $approverName = Auth::check() ? Auth::user()->name : 'System Approver';
        $approvedAt = now()->format('Y-m-d H:i:s');

        if ($dr) {
            $itemsData = is_array($dr->items) ? $dr->items : json_decode($dr->items ?? '[]', true);
            $itemsData['approved_by'] = $approverName;
            $itemsData['approved_at'] = $approvedAt;
            $dr->items = $itemsData;
            $dr->save();

            if ($dr->purchaseOrder) {
                $dr->purchaseOrder->status = 'received';
                $dr->purchaseOrder->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment approved successfully!',
            'approved_by' => $approverName,
            'approved_at' => $approvedAt,
            'status' => 'Approved for Payment'
        ]);
    }
}
