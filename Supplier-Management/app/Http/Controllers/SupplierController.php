<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Mock "database" of suppliers, keyed by slug.
     * In a real app this would come from an Eloquent model / DB table.
     */
    protected function suppliers(): array
    {
        return [
            'abc-farms' => [
                'slug' => 'abc-farms',
                'name' => 'ABC Farms',
                'supplier_id' => 'AGR-00125',
                'since' => 'Jan 15, 2025',
                'description' => 'ABC Farms is a trusted agricultural supplier providing high quality farm products.',
                'business_type' => 'Farm',
                'address' => 'Barangay San Isidro, Cabanatuan City Nueva Ecija, Philippines',
                'phone' => '+63 917 123 4567',
                'email' => 'abcfarms@gmail.com',
                'location' => 'Nueva Ecija',
                'products_list' => 'Rice, Corn, Onion',
                'rating' => 4.5,
                'status' => 'Active',
                'last_transaction' => 'Jun 18, 2026',
                'contact_name' => 'Juan Dela Cruz',
                'contact_role' => 'Farm Manager',
                'total_orders' => 25,
                'total_spent' => '₱523,450.00',
                'avg_order_value' => '₱11,632.00',
                'on_time_rate' => '93%',
                'products' => [
                    ['name' => 'Rice', 'code' => '-', 'category' => 'Grains', 'unit' => '50kg Sack', 'price' => '₱2,450.00', 'stock' => 'In Stock', 'moq' => '10 Sacks', 'lead_time' => '2-3 Business Days'],
                    ['name' => 'Corn', 'code' => '-', 'category' => 'Grains', 'unit' => '50kg Sack', 'price' => '₱1,850.00', 'stock' => 'In Stock', 'moq' => '10 Sacks', 'lead_time' => '2-3 Business Days'],
                    ['name' => 'Onion', 'code' => '-', 'category' => 'Vegetables', 'unit' => '20kg Sack', 'price' => '₱1,500.00', 'stock' => 'In Stock', 'moq' => '5 Sacks', 'lead_time' => '1-2 Business Days'],
                ],
                'purchase_history' => [
                    ['date' => 'Jun 18, 2026', 'po_number' => 'PO-1024', 'product' => 'Rice', 'quantity' => '120 sacks', 'amount' => '₱245,000.00', 'status' => 'Delivered'],
                    ['date' => 'May 22, 2026', 'po_number' => 'PO-0998', 'product' => 'Corn', 'quantity' => '80 sacks', 'amount' => '₱148,000.00', 'status' => 'Completed'],
                ],
                'contract' => [
                    'start' => 'Jan 15, 2026',
                    'end' => 'Jan 15, 2027',
                    'duration' => '1 Year',
                    'days_remaining' => '198 days left',
                    'payment_terms' => 'Net 30',
                    'auto_renewal' => 'Enabled',
                    'document' => 'Supply Agreement - ABC Farms.pdf',
                    'document_size' => '1.2 MB',
                    'scope' => [
                        'Supply of fresh vegetables, rice and agricultural products',
                        'Ensure product quality and timely delivery',
                        'Compliance with company standards and policies',
                        'Maintain proper packaging and documentation',
                    ],
                    'history' => [
                        ['date' => 'Jan 01, 2025', 'action' => 'Contract Created', 'by' => 'Juan Dela Cruz', 'remarks' => 'Initial Contract creation'],
                        ['date' => 'Jan 15, 2025', 'action' => 'Contract Signed', 'by' => 'ABC Farms', 'remarks' => 'Contract signed by company'],
                        ['date' => 'Jan 15, 2026', 'action' => 'Contract Updated', 'by' => 'Juan Dela Cruz', 'remarks' => 'Renewal of Contract'],
                    ],
                ],
                'performance' => [
                    'avg_rating' => '4.5', 'avg_rating_delta' => '↑ 0.2 from last month',
                    'on_time' => '92%', 'on_time_delta' => '↑ 5% from last month',
                    'quality_score' => '4.6', 'quality_delta' => '↑ 5% from last month',
                    'total_orders' => '2,245', 'total_orders_delta' => '↑ 79 this month',
                ],
            ],
            'green-harvest' => [
                'slug' => 'green-harvest',
                'name' => 'Green Harvest',
                'supplier_id' => 'AGR-00117',
                'since' => 'Feb 03, 2025',
                'description' => 'Green Harvest supplies fresh vegetables sourced from Benguet highland farms.',
                'business_type' => 'Cooperative',
                'address' => 'La Trinidad, Benguet, Philippines',
                'phone' => '+63 918 222 3344',
                'email' => 'greenharvest@gmail.com',
                'location' => 'Benguet',
                'products_list' => 'Vegetables, Lettuce, Cabbage',
                'rating' => 3.5,
                'status' => 'Blacklisted',
                'last_transaction' => 'Jun 17, 2026',
                'contact_name' => 'Maria Santos',
                'contact_role' => 'Cooperative Head',
                'total_orders' => 309,
                'total_spent' => '₱210,300.00',
                'avg_order_value' => '₱6,805.00',
                'on_time_rate' => '78%',
                'products' => [
                    ['name' => 'Lettuce', 'code' => '-', 'category' => 'Vegetables', 'unit' => '10kg Crate', 'price' => '₱950.00', 'stock' => 'Low Stock', 'moq' => '5 Crates', 'lead_time' => '2-3 Business Days'],
                    ['name' => 'Cabbage', 'code' => '-', 'category' => 'Vegetables', 'unit' => '20kg Sack', 'price' => '₱1,100.00', 'stock' => 'In Stock', 'moq' => '5 Sacks', 'lead_time' => '2-3 Business Days'],
                ],
                'purchase_history' => [
                    ['date' => 'Jun 17, 2026', 'po_number' => 'PO-1017', 'product' => 'Lettuce', 'quantity' => '60 crates', 'amount' => '₱57,000.00', 'status' => 'Pending'],
                    ['date' => 'Apr 08, 2026', 'po_number' => 'PO-0921', 'product' => 'Cabbage', 'quantity' => '45 sacks', 'amount' => '₱49,500.00', 'status' => 'Completed'],
                ],
                'contract' => [
                    'start' => 'Feb 03, 2025', 'end' => 'Feb 03, 2026', 'duration' => '1 Year',
                    'days_remaining' => 'Expired', 'payment_terms' => 'Net 15', 'auto_renewal' => 'Disabled',
                    'document' => 'Supply Agreement - Green Harvest.pdf', 'document_size' => '980 KB',
                    'scope' => ['Supply of fresh vegetables', 'Compliance with quality standards'],
                    'history' => [
                        ['date' => 'Feb 03, 2025', 'action' => 'Contract Created', 'by' => 'Maria Santos', 'remarks' => 'Initial Contract creation'],
                        ['date' => 'Jan 12, 2026', 'action' => 'Supplier Blacklisted', 'by' => 'Admin', 'remarks' => 'Failed Quality Inspection'],
                    ],
                ],
                'performance' => [
                    'avg_rating' => '3.5', 'avg_rating_delta' => '↓ 0.3 from last month',
                    'on_time' => '78%', 'on_time_delta' => '↓ 4% from last month',
                    'quality_score' => '3.0', 'quality_delta' => '↓ 1.1 from last month',
                    'total_orders' => '309', 'total_orders_delta' => '↑ 5 this month',
                ],
            ],
            'fresh-mango-co' => [
                'slug' => 'fresh-mango-co',
                'name' => 'Fresh Mango Co.',
                'supplier_id' => 'AGR-00133',
                'since' => 'Mar 20, 2025',
                'description' => 'Fresh Mango Co. supplies premium mangoes sourced from Guimaras orchards.',
                'business_type' => 'Farm',
                'address' => 'Buenavista, Guimaras, Philippines',
                'phone' => '+63 919 555 7788',
                'email' => 'freshmango@gmail.com',
                'location' => 'Guimaras',
                'products_list' => 'Mango',
                'rating' => 4.0,
                'status' => 'Active',
                'last_transaction' => 'Jun 14, 2026',
                'contact_name' => 'Ana Reyes',
                'contact_role' => 'Farm Owner',
                'total_orders' => 578,
                'total_spent' => '₱780,900.00',
                'avg_order_value' => '₱13,510.00',
                'on_time_rate' => '95%',
                'products' => [
                    ['name' => 'Mango', 'code' => '-', 'category' => 'Fruits', 'unit' => '15kg Box', 'price' => '₱2,100.00', 'stock' => 'In Stock', 'moq' => '5 Boxes', 'lead_time' => '1-2 Business Days'],
                ],
                'purchase_history' => [
                    ['date' => 'Jun 14, 2026', 'po_number' => 'PO-1004', 'product' => 'Mango', 'quantity' => '80 boxes', 'amount' => '₱168,000.00', 'status' => 'Delivered'],
                    ['date' => 'May 30, 2026', 'po_number' => 'PO-0978', 'product' => 'Mango', 'quantity' => '40 boxes', 'amount' => '₱84,000.00', 'status' => 'Completed'],
                ],
                'contract' => [
                    'start' => 'Mar 20, 2025', 'end' => 'Mar 20, 2027', 'duration' => '2 Years',
                    'days_remaining' => '256 days left', 'payment_terms' => 'Net 30', 'auto_renewal' => 'Enabled',
                    'document' => 'Supply Agreement - Fresh Mango Co.pdf', 'document_size' => '1.4 MB',
                    'scope' => ['Supply of fresh mangoes', 'Ensure ripeness grading and timely delivery'],
                    'history' => [
                        ['date' => 'Mar 20, 2025', 'action' => 'Contract Created', 'by' => 'Ana Reyes', 'remarks' => 'Initial Contract creation'],
                    ],
                ],
                'performance' => [
                    'avg_rating' => '4.0', 'avg_rating_delta' => '↑ 0.1 from last month',
                    'on_time' => '95%', 'on_time_delta' => '↑ 2% from last month',
                    'quality_score' => '4.2', 'quality_delta' => '↑ 0.2 from last month',
                    'total_orders' => '578', 'total_orders_delta' => '↑ 12 this month',
                ],
            ],
            'coconut-valley' => [
                'slug' => 'coconut-valley',
                'name' => 'Coconut Valley',
                'supplier_id' => 'AGR-00109',
                'since' => 'Apr 05, 2025',
                'description' => 'Coconut Valley is a leading coconut supplier from Quezon province.',
                'business_type' => 'Farm',
                'address' => 'Lucena City, Quezon, Philippines',
                'phone' => '+63 920 111 9900',
                'email' => 'coconutvalley@gmail.com',
                'location' => 'Quezon',
                'products_list' => 'Coconut',
                'rating' => 4.5,
                'status' => 'Active',
                'last_transaction' => 'Jun 10, 2026',
                'contact_name' => 'Pedro Ramos',
                'contact_role' => 'Operations Manager',
                'total_orders' => 1899,
                'total_spent' => '₱1,230,600.00',
                'avg_order_value' => '₱9,750.00',
                'on_time_rate' => '90%',
                'products' => [
                    ['name' => 'Coconut', 'code' => '-', 'category' => 'Fruits', 'unit' => '100pcs Sack', 'price' => '₱1,200.00', 'stock' => 'In Stock', 'moq' => '10 Sacks', 'lead_time' => '2-3 Business Days'],
                ],
                'purchase_history' => [
                    ['date' => 'Jun 10, 2026', 'po_number' => 'PO-0987', 'product' => 'Coconut', 'quantity' => '100 sacks', 'amount' => '₱120,000.00', 'status' => 'Delivered'],
                    ['date' => 'May 14, 2026', 'po_number' => 'PO-0945', 'product' => 'Coconut', 'quantity' => '70 sacks', 'amount' => '₱84,000.00', 'status' => 'Completed'],
                ],
                'contract' => [
                    'start' => 'Apr 05, 2025', 'end' => 'Apr 05, 2027', 'duration' => '2 Years',
                    'days_remaining' => '272 days left', 'payment_terms' => 'Net 30', 'auto_renewal' => 'Enabled',
                    'document' => 'Supply Agreement - Coconut Valley.pdf', 'document_size' => '1.1 MB',
                    'scope' => ['Supply of coconuts', 'Maintain proper packaging and documentation'],
                    'history' => [
                        ['date' => 'Apr 05, 2025', 'action' => 'Contract Created', 'by' => 'Pedro Ramos', 'remarks' => 'Initial Contract creation'],
                    ],
                ],
                'performance' => [
                    'avg_rating' => '4.5', 'avg_rating_delta' => '↑ 0.3 from last month',
                    'on_time' => '90%', 'on_time_delta' => '↑ 1% from last month',
                    'quality_score' => '4.4', 'quality_delta' => '↑ 0.1 from last month',
                    'total_orders' => '1,899', 'total_orders_delta' => '↑ 40 this month',
                ],
            ],
        ];
    }

    protected function blacklisted(): array
    {
        return [
            ['supplier' => 'Green Harvest', 'slug' => 'green-harvest', 'supplier_id' => 'AGR-00117', 'reason' => 'Failed Quality Inspection', 'since' => 'Jan. 12, 2026', 'risk' => 'High'],
            ['supplier' => 'Sunrise Corp.', 'slug' => null, 'supplier_id' => 'ARG-05843', 'reason' => 'Expired Certification', 'since' => 'Jan. 12, 2026', 'risk' => 'Low'],
            ['supplier' => 'XYZ', 'slug' => null, 'supplier_id' => 'AGR-02457', 'reason' => 'Fraudulent Contract', 'since' => 'Jan. 12, 2026', 'risk' => 'Critical'],
            ['supplier' => 'Sunrise Corp.', 'slug' => null, 'supplier_id' => 'AGR-05487', 'reason' => 'Non-compliance', 'since' => 'Jan. 12, 2026', 'risk' => 'Medium'],
        ];
    }

    protected function activeSuppliers(): array
    {
        return array_values(array_filter($this->suppliers(), fn ($supplier) => $supplier['status'] === 'Active'));
    }

    protected function pendingSuppliers(): array
    {
        return array_values(array_filter($this->suppliers(), fn ($supplier) => $supplier['status'] === 'Pending Verification'));
    }

    protected function stats(): array
    {
        return [
            'total' => count($this->suppliers()),
            'active' => count($this->activeSuppliers()),
            'pending' => count($this->pendingSuppliers()),
            'blacklisted' => count($this->blacklisted()),
        ];
    }

    // Image 1 - Supplier Management dashboard
    public function dashboard()
    {
        return view('suppliers::suppliers.dashboard', [
            'suppliers' => $this->suppliers(),
            'stats' => $this->stats(),
        ]);
    }

    // Image 3 - Suppliers list
    public function index()
    {
        return view('suppliers::suppliers.index', [
            'suppliers' => $this->suppliers(),
        ]);
    }

    public function activeIndex()
    {
        return view('suppliers::suppliers.active', [
            'suppliers' => $this->activeSuppliers(),
        ]);
    }

    public function pendingIndex()
    {
        return view('suppliers::suppliers.pending', [
            'suppliers' => $this->pendingSuppliers(),
        ]);
    }

    // Image 2 - Add new supplier form
    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        // Mock save - in a real app you'd validate & persist here.
        return redirect()->route('suppliers.index')->with('status', 'Supplier saved successfully.');
    }

    // Image 4 - Supplier overview
    public function show(string $supplier)
    {
        $suppliers = $this->suppliers();
        abort_if(!isset($suppliers[$supplier]), 404);

        return view('suppliers::suppliers.show', [
            'supplier' => $suppliers[$supplier],
        ]);
    }

    // Image 5 - Product details
    public function products(string $supplier)
    {
        $suppliers = $this->suppliers();
        abort_if(!isset($suppliers[$supplier]), 404);

        return view('suppliers::suppliers.products', [
            'supplier' => $suppliers[$supplier],
        ]);
    }

    // Image 6 - Purchase history
    public function purchaseHistory(string $supplier)
    {
        $suppliers = $this->suppliers();
        abort_if(!isset($suppliers[$supplier]), 404);

        return view('suppliers::suppliers.purchase-history', [
            'supplier' => $suppliers[$supplier],
        ]);
    }

    // Image 7 - Contract information
    public function contract(string $supplier)
    {
        $suppliers = $this->suppliers();
        abort_if(!isset($suppliers[$supplier]), 404);

        return view('suppliers::suppliers.contract', [
            'supplier' => $suppliers[$supplier],
        ]);
    }

    // Image 8 - Performance
    public function performance(string $supplier)
    {
        $suppliers = $this->suppliers();
        abort_if(!isset($suppliers[$supplier]), 404);

        return view('suppliers::suppliers.performance', [
            'supplier' => $suppliers[$supplier],
        ]);
    }

    // Image 9 - Blacklisted suppliers
    public function blacklistedIndex()
    {
        return view('suppliers::suppliers.blacklisted', [
            'blacklisted' => $this->blacklisted(),
            'stats' => $this->stats(),
        ]);
    }
}
