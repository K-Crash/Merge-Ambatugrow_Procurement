<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatchingController extends Controller
{
    private function getMockData()
    {
        return [
            [
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
                'status' => 'Matched', // Green
                'supplier_initials' => 'SG',
            ],
            [
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
                'status' => 'Partial Match', // Orange
                'supplier_initials' => 'HA',
            ],
            [
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
                'status' => 'Pending Invoice', // Purple
                'supplier_initials' => 'DF',
            ],
            [
                'po_number' => 'PO-2024-00033', // Note PO-2024-00033 is shared or duplicated for different suppliers in the images
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
                'status' => 'Pending Receipt', // Purple
                'supplier_initials' => 'ZV',
            ],
            [
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
                'status' => 'Mismatch', // Red
                'supplier_initials' => 'PS',
            ],
            [
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
                'status' => 'Matched', // Green
                'supplier_initials' => 'SG',
            ],
            [
                'po_number' => 'PO-2024-00014',
                'po_date' => '21 Jun 2024',
                'supplier' => 'Agri-Source International',
                'commodity' => 'Sorghum',
                'payment_terms' => 'Net 45',
                'warehouse' => 'Bulawayo Grain Silo',
                'grn_number' => 'GRN-2024-03362',
                'grn_date' => '26 Jun 2024',
                'invoice_number' => 'INV-AS-2293',
                'invoice_date' => '27 Jun 2024',
                'po_amount' => 205500.00,
                'invoice_amount' => 205500.00,
                'variance' => -20500.00,
                'status' => 'Partial Match', // Orange
                'supplier_initials' => 'AS',
            ],
            [
                'po_number' => 'PO-2024-00028',
                'po_date' => '22 Jun 2024',
                'supplier' => 'Limpopo Harvest Co.',
                'commodity' => 'Groundnuts',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Masvingo Depot',
                'grn_number' => null,
                'grn_date' => null,
                'invoice_number' => null,
                'invoice_date' => null,
                'po_amount' => 88000.00,
                'invoice_amount' => 0.0,
                'variance' => 0.0,
                'status' => 'Pending Receipt', // Purple
                'supplier_initials' => 'LH',
            ],
            [
                'po_number' => 'PO-2024-00033', // Highland Agricultural shares this number in the image
                'po_date' => '23 Jun 2024',
                'supplier' => 'Highland Agricultural',
                'commodity' => 'Barley',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => 'GRN-2024-03301',
                'grn_date' => '27 Jun 2024',
                'invoice_number' => 'INV-HL-5547',
                'invoice_date' => '28 Jun 2024',
                'po_amount' => 231000.00,
                'invoice_amount' => 231000.00,
                'variance' => 0.0,
                'status' => 'Matched', // Green
                'supplier_initials' => 'HA',
            ],
            [
                'po_number' => 'PO-2024-00047',
                'po_date' => '24 Jun 2024',
                'supplier' => 'Delta Farm Supplies',
                'commodity' => 'Black-eyed Beans',
                'payment_terms' => 'Net 30',
                'warehouse' => 'Harare Central Depot',
                'grn_number' => 'GRN-2024-03304',
                'grn_date' => '28 Jun 2024',
                'invoice_number' => null,
                'invoice_date' => null,
                'po_amount' => 154600.00,
                'invoice_amount' => 0.0,
                'variance' => 0.0,
                'status' => 'Pending Invoice', // Purple
                'supplier_initials' => 'DF',
            ]
        ];
    }

    public function index(Request $request)
    {
        $statusFilter = $request->input('status', 'All');
        $searchQuery = $request->input('search');
        $supplierFilter = $request->input('supplier');

        $allData = $this->getMockData();
        $filteredData = $allData;

        // Apply Status Filter
        if ($statusFilter !== 'All') {
            $filteredData = array_filter($filteredData, function ($item) use ($statusFilter) {
                return strtolower($item['status']) === strtolower($statusFilter);
            });
        }

        // Apply Supplier Filter
        if ($supplierFilter && $supplierFilter !== 'All Suppliers') {
            $filteredData = array_filter($filteredData, function ($item) use ($supplierFilter) {
                return $item['supplier'] === $supplierFilter;
            });
        }

        // Apply Search Query
        if ($searchQuery) {
            $searchQuery = strtolower($searchQuery);
            $filteredData = array_filter($filteredData, function ($item) use ($searchQuery) {
                return str_contains(strtolower($item['po_number']), $searchQuery) ||
                       str_contains(strtolower($item['supplier']), $searchQuery) ||
                       str_contains(strtolower($item['commodity']), $searchQuery) ||
                       str_contains(strtolower($item['grn_number'] ?? ''), $searchQuery) ||
                       str_contains(strtolower($item['invoice_number'] ?? ''), $searchQuery);
            });
        }

        // Extract list of unique suppliers for the filter dropdown
        $suppliersList = array_unique(array_column($allData, 'supplier'));
        sort($suppliersList);

        // Find active record for details panel (default to first matching or first item)
        $selectedPo = $request->input('selected_po');
        $selectedRecord = null;
        if ($selectedPo) {
            foreach ($allData as $item) {
                // To avoid duplication conflicts since PO-2024-00033 appears twice,
                // we can match both PO and Supplier to get the unique record.
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

        // If it's an AJAX request (e.g. for dynamic row-click or search), return JSON
        if ($request->ajax()) {
            return response()->json([
                'records' => array_values($filteredData),
                'count' => count($filteredData),
                'selected' => $selectedRecord
            ]);
        }

        return view('grim::dashboard', [
            'records' => $filteredData,
            'allRecords' => $allData,
            'suppliers' => $suppliersList,
            'selectedRecord' => $selectedRecord,
            'currentStatus' => $statusFilter,
            'currentSearch' => $searchQuery,
            'currentSupplier' => $supplierFilter
        ]);
    }
}
