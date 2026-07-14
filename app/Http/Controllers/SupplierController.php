<?php

namespace App\Http\Controllers;

use App\Models\BlacklistedSupplier;
use App\Models\Supplier;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\UnitOfMeasure;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    protected function stats(): array
    {
        $total = Supplier::count();

        return [
            'total' => $total,
            'active' => Supplier::where('status', 'Active')->count(),
            'pending' => Supplier::where('status', 'Pending Verification')->count(),
            'blacklisted' => Supplier::where('status', 'Blacklisted')->count()
                + BlacklistedSupplier::count(),
        ];
    }

    /**
     * Combines suppliers with status=Blacklisted with standalone blacklist-only entries.
     */
    protected function blacklisted()
    {
        $fromSuppliers = Supplier::where('status', 'Blacklisted')->get()->map(fn ($s) => [
            'supplier' => $s->supplier_name,
            'slug' => $s->slug,
            'supplier_id' => $s->supplier_id,
            'reason' => $s->blacklist_reason,
            'since' => $s->blacklisted_since ? $s->blacklisted_since->format('M. d, Y') : null,
            'risk' => $s->risk_level,
        ]);

        $standalone = BlacklistedSupplier::all()->map(fn ($b) => [
            'supplier' => $b->name,
            'slug' => null,
            'supplier_id' => $b->supplier_code,
            'reason' => $b->reason,
            'since' => $b->since,
            'risk' => $b->risk_level,
        ]);

        return $fromSuppliers->concat($standalone)->values();
    }

    // Image 1 - Supplier Management dashboard
    public function dashboard()
    {
        $suppliers = Supplier::latest()->get()->toArray();

        return view('suppliers.dashboard', [
            'suppliers' => $suppliers,
            'stats' => $this->stats(),
        ]);
    }

    // Image 3 - Suppliers list
    public function index(Request $request)
    {
        $keyword = (string) $request->query('q', '');
        $keyword = trim($keyword);

        $query = Supplier::query();

        if ($keyword !== '') {
            $pattern = "%{$keyword}%";

            $query->where(function ($q) use ($pattern) {
                $q->where('supplier_name', 'like', $pattern)
                  ->orWhere('location', 'like', $pattern)
                  ->orWhere('supplier_code', 'like', $pattern)
                  ->orWhere('supplier_id', 'like', $pattern)
                  ->orWhereHas('productsRelation', function ($p) use ($pattern) {
                      $p->where('name', 'like', $pattern);
                  });
            });
        }

        $suppliers = $query->latest()->get()->toArray();

        return view('suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function activeIndex()
    {
        $suppliers = Supplier::where('status', 'Active')->latest()->get()->toArray();

        return view('suppliers.active', [
            'suppliers' => $suppliers,
        ]);
    }

    public function pendingIndex()
    {
        $suppliers = Supplier::where('status', 'Pending Verification')->latest()->get()->toArray();

        return view('suppliers.pending', [
            'suppliers' => $suppliers,
        ]);
    }

    // Image 2 - Add new supplier form
    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email', 'max:255'],
            'lead_time' => ['required', 'string'],
            'delivery_schedule' => ['required', 'string'],
            'moq' => ['required', 'string'],
            'products' => ['required', 'array', 'min:1'],
            'payment_terms' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $baseSlug = Str::slug($data['company_name']);
        $slug = $baseSlug;
        $i = 1;
        while (Supplier::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        try {
            // 1. Create address
            $supplierAddress = Address::create([
                'street' => $data['address'],
                'city' => 'Manila',
                'province' => 'Metro Manila',
                'zipcode' => '1000',
                'country' => 'Philippines',
            ]);

            // 2. Create supplier
            $supplier = Supplier::create([
                'slug' => $slug,
                'supplier_name' => $data['company_name'],
                'name' => $data['company_name'],
                'supplier_id' => 'AGR-' . str_pad((string) (Supplier::count() + 1), 5, '0', STR_PAD_LEFT),
                'business_type' => $data['business_type'],
                'address_id' => $supplierAddress->id,
                'phone' => $data['phone'],
                'email' => $data['email'],
                'contact_name' => $data['contact_person'],
                'contact_role' => $data['position'],
                'contact_phone' => $data['contact_phone'],
                'contact_email' => $data['contact_email'],
                'lead_time' => $data['lead_time'],
                'delivery_schedule' => $data['delivery_schedule'],
                'moq' => $data['moq'],
                'payment_terms' => $data['payment_terms'],
                'payment_method' => $data['payment_method'],
                'description' => $data['description'] ?? null,
                'status' => 'Pending Verification',
                'since' => now(),
                'location' => 'Metro Manila',
            ]);

            // 3. Attach products
            foreach ($data['products'] as $prodName) {
                $product = Product::where('name', $prodName)->first();
                if (!$product) {
                    $grains = Category::firstOrCreate(['category_name' => 'Grains']);
                    $uom = UnitOfMeasure::firstOrCreate(['uom_code' => 'Sack'], ['uom_name' => '50kg Sack']);
                    $currency = Currency::firstOrCreate(['currency_code' => 'PHP'], ['currency_name' => 'Philippine Peso', 'exchange_rate' => 1.0]);
                    
                    $product = Product::create([
                        'sku' => 'PRD-' . strtoupper(Str::slug($prodName)),
                        'name' => $prodName,
                        'description' => $prodName,
                        'category_id' => $grains->id,
                        'uom_id' => $uom->id,
                        'currency_id' => $currency->id,
                        'base_price' => 1000.00,
                        'min_quantity_threshold' => 10.00,
                        'lead_time_days' => 3,
                    ]);
                }

                $supplier->productsRelation()->attach($product->id, [
                    'supplier_sku' => $supplier->supplier_id . '-' . strtoupper(substr($prodName, 0, 3)),
                    'unit_price' => $product->base_price,
                    'lead_time_days' => $product->lead_time_days,
                    'is_preferred' => true,
                ]);
            }

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors(['db' => 'Unable to save supplier: ' . $e->getMessage()]);
        }

        if ($supplier && $supplier->id) {
            return redirect()->route('suppliers.index')->with('status', 'Supplier saved successfully.');
        }

        return redirect()->back()->withInput()->withErrors(['db' => 'Unknown error creating supplier.']);
    }

    // Image 4 - Supplier overview
    public function show(string $supplier)
    {
        $s = Supplier::with(['productsRelation', 'purchaseOrders', 'contractHistoryEntries', 'addressRelation'])
            ->where('slug', $supplier)->firstOrFail();

        $data = $s->toArray();
        $data['products'] = $s->products;
        $data['purchase_history'] = $s->purchase_history;

        return view('suppliers.show', [
            'supplier' => $data,
        ]);
    }

    // Image 5 - Product details
    public function products(string $supplier)
    {
        $s = Supplier::with('productsRelation')->where('slug', $supplier)->firstOrFail();

        $data = $s->toArray();
        $data['products'] = $s->products;

        return view('suppliers.products', [
            'supplier' => $data,
        ]);
    }

    // Image 6 - Purchase history
    public function purchaseHistory(string $supplier)
    {
        $s = Supplier::with('purchaseOrders')->where('slug', $supplier)->firstOrFail();

        $data = $s->toArray();
        $data['purchase_history'] = $s->purchase_history;

        return view('suppliers.purchase-history', [
            'supplier' => $data,
        ]);
    }

    // Image 7 - Contract information
    public function contract(string $supplier)
    {
        $s = Supplier::with('contractHistoryEntries')->where('slug', $supplier)->firstOrFail();

        return view('suppliers.contract', [
            'supplier' => $s->toArray(),
        ]);
    }

    // Image 8 - Performance
    public function performance(string $supplier)
    {
        $s = Supplier::with(['productsRelation', 'purchaseOrders'])->where('slug', $supplier)->firstOrFail();

        $data = $s->toArray();
        $data['products'] = $s->products;
        $data['purchase_history'] = $s->purchase_history;

        return view('suppliers.performance', [
            'supplier' => $data,
        ]);
    }

    // Image 9 - Blacklisted suppliers
    public function blacklistedIndex()
    {
        return view('suppliers.blacklisted', [
            'blacklisted' => $this->blacklisted(),
            'stats' => $this->stats(),
        ]);
    }
}
