<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Invoice;
use Carbon\Carbon;

class PurchaseOrderSeeder extends Seeder
{
    public function run()
    {
        // 1. PO-2026-001 (Green Harvest Co. - Overdue Sent)
        $po1 = PurchaseOrder::create([
            'po_number' => 'PO-2026-001',
            'supplier_id' => 3,
            'status' => 'sent',
            'expected_delivery' => Carbon::now()->subDays(5),
            'issued_at' => Carbon::now()->subDays(12),
        ]);
        $po1->items()->createMany([
            ['sku' => 'GRN-FERT-001', 'name' => 'Organic Fertilizer Bags', 'quantity' => 15, 'unit_price' => 950.00, 'line_total' => 14250.00],
            ['sku' => 'GRN-SOIL-002', 'name' => 'Organic Potting Soil (20kg Bag)', 'quantity' => 30, 'unit_price' => 250.00, 'line_total' => 7500.00],
            ['sku' => 'GRN-SEED-011', 'name' => 'Hybrid Tomato Seeds (Pack of 50)', 'quantity' => 10, 'unit_price' => 120.00, 'line_total' => 1200.00],
            ['sku' => 'GRN-IRRI-013', 'name' => 'Drip Irrigation Emitter (Pack of 100)', 'quantity' => 5, 'unit_price' => 600.00, 'line_total' => 3000.00],
        ]);

        // 2. PO-2026-002 (TechVend Solutions - Sent with Matched Invoice)
        $po2 = PurchaseOrder::create([
            'po_number' => 'PO-2026-002',
            'supplier_id' => 1,
            'status' => 'sent',
            'expected_delivery' => Carbon::now()->addDays(8),
            'issued_at' => Carbon::now()->subDays(2),
        ]);
        $po2->items()->createMany([
            ['sku' => 'TEC-LAP-002', 'name' => 'Developer Workstation Laptop', 'quantity' => 1, 'unit_price' => 58000.00, 'line_total' => 58000.00],
            ['sku' => 'TEC-ADPT-004', 'name' => 'USB-C Multiport Adapter', 'quantity' => 4, 'unit_price' => 1800.00, 'line_total' => 7200.00],
            ['sku' => 'TEC-SSD-005', 'name' => 'External 1TB SSD Drive', 'quantity' => 3, 'unit_price' => 4500.00, 'line_total' => 13500.00],
            ['sku' => 'TEC-HDST-010', 'name' => 'Noise-Cancelling USB Headset', 'quantity' => 5, 'unit_price' => 3200.00, 'line_total' => 16000.00],
        ]);

        // Create Invoice for PO-2026-002
        Invoice::create([
            'invoice_number' => 'INV-SUP-2026-002',
            'supplier_id' => 1,
            'purchase_order_id' => $po2->id,
            'amount' => 94700.00,
            'received_at' => Carbon::now()->subDays(1),
        ]);

        // 3. PO-2026-003 (OfficeMax PH - Fully Received)
        $po3 = PurchaseOrder::create([
            'po_number' => 'PO-2026-003',
            'supplier_id' => 2,
            'status' => 'received',
            'expected_delivery' => Carbon::now()->subDays(3),
            'issued_at' => Carbon::now()->subDays(10),
        ]);
        $po3->items()->createMany([
            ['sku' => 'OFF-PPR-009', 'name' => 'Premium A4 Paper Reams', 'quantity' => 50, 'unit_price' => 210.00, 'line_total' => 10500.00],
            ['sku' => 'OFF-CHR-001', 'name' => 'Ergonomic Office Chair', 'quantity' => 4, 'unit_price' => 6500.00, 'line_total' => 26000.00],
            ['sku' => 'OFF-LAMP-003', 'name' => 'LED Desk Lamp with USB Charger', 'quantity' => 6, 'unit_price' => 1450.00, 'line_total' => 8700.00],
            ['sku' => 'OFF-WBD-006', 'name' => 'Whiteboard Magnetic 4x3ft', 'quantity' => 2, 'unit_price' => 3200.00, 'line_total' => 6400.00],
            ['sku' => 'OFF-MKR-007', 'name' => 'Dry Erase Markers (Pack of 12)', 'quantity' => 8, 'unit_price' => 380.00, 'line_total' => 3040.00],
        ]);

        // Create Invoice for PO-2026-003
        Invoice::create([
            'invoice_number' => 'INV-SUP-2026-003',
            'supplier_id' => 2,
            'purchase_order_id' => $po3->id,
            'amount' => 54640.00,
            'received_at' => Carbon::now()->subDays(2),
        ]);

        // 4. PO-2026-004 (TechVend Solutions - Draft)
        $po4 = PurchaseOrder::create([
            'po_number' => 'PO-2026-004',
            'supplier_id' => 1,
            'status' => 'draft',
            'expected_delivery' => Carbon::now()->addDays(12),
            'issued_at' => null,
        ]);
        $po4->items()->createMany([
            ['sku' => 'TEC-MON-005', 'name' => '24-inch IPS Monitor', 'quantity' => 2, 'unit_price' => 6800.00, 'line_total' => 13600.00],
            ['sku' => 'TEC-KBD-002', 'name' => 'Wireless Keyboard & Mouse Combo', 'quantity' => 5, 'unit_price' => 1800.00, 'line_total' => 9000.00],
            ['sku' => 'TEC-SCRN-009', 'name' => 'Privacy Screen Filter 24-inch', 'quantity' => 2, 'unit_price' => 1250.00, 'line_total' => 2500.00],
        ]);

        // 5. PO-2026-005 (Green Harvest Co. - Sent)
        $po5 = PurchaseOrder::create([
            'po_number' => 'PO-2026-005',
            'supplier_id' => 3,
            'status' => 'sent',
            'expected_delivery' => Carbon::now()->addDays(6),
            'issued_at' => Carbon::now()->subDays(1),
        ]);
        $po5->items()->createMany([
            ['sku' => 'GRN-SHR-014', 'name' => 'Pruning Shears Heavy Duty', 'quantity' => 8, 'unit_price' => 450.00, 'line_total' => 3600.00],
            ['sku' => 'GRN-HOSE-015', 'name' => 'Garden Hose Reel Cart', 'quantity' => 3, 'unit_price' => 2200.00, 'line_total' => 6600.00],
            ['sku' => 'GRN-TRAY-016', 'name' => 'Biodegradable Seed Starter Trays', 'quantity' => 20, 'unit_price' => 95.00, 'line_total' => 1900.00],
            ['sku' => 'GRN-NET-017', 'name' => 'Nylon Plant Trellis Netting', 'quantity' => 15, 'unit_price' => 180.00, 'line_total' => 2700.00],
        ]);

        // 6. PO-2026-006 (Green Harvest Co. - Draft)
        $po6 = PurchaseOrder::create([
            'po_number' => 'PO-2026-006',
            'supplier_id' => 3,
            'status' => 'draft',
            'expected_delivery' => Carbon::now()->addDays(14),
            'issued_at' => null,
        ]);
        $po6->items()->createMany([
            ['sku' => 'GRN-FERT-018', 'name' => 'Liquid Seaweed Fertilizer (5L)', 'quantity' => 12, 'unit_price' => 850.00, 'line_total' => 10200.00],
            ['sku' => 'GRN-GLV-019', 'name' => 'Heavy Duty Gardening Gloves (M)', 'quantity' => 25, 'unit_price' => 140.00, 'line_total' => 3500.00],
            ['sku' => 'GRN-TST-020', 'name' => 'pH Soil Tester Moisture Meter', 'quantity' => 10, 'unit_price' => 650.00, 'line_total' => 6500.00],
        ]);

        // Recalculate totals for all Purchase Orders
        foreach (PurchaseOrder::all() as $po) {
            $po->total = $po->items->sum('line_total');
            $po->save();
        }
    }
}
