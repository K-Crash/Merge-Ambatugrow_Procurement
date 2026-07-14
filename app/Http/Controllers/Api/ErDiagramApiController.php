<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\Currency;
use App\Models\PaymentTerm;
use App\Models\UnitOfMeasure;
use App\Models\Address;
use Illuminate\Http\Request;

class ErDiagramApiController extends Controller
{
    public function suppliers()
    {
        $suppliers = Supplier::with('addressRelation')->withCount('productsRelation')->get();
        return response()->json($suppliers);
    }

    public function showSupplier($id)
    {
        $supplier = Supplier::with(['addressRelation', 'productsRelation', 'purchaseOrders', 'supplierInvoices'])->find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        return response()->json($supplier);
    }

    public function products()
    {
        $products = Product::with(['category', 'uom', 'currency'])->get();
        return response()->json($products);
    }

    public function productSuppliers($id)
    {
        $product = Product::with('suppliers')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product->suppliers);
    }

    public function purchaseOrders()
    {
        $pos = PurchaseOrder::with(['supplier', 'paymentTerm', 'currency', 'creator'])->get();
        return response()->json($pos);
    }

    public function showPurchaseOrder($id)
    {
        $po = PurchaseOrder::with(['supplier', 'paymentTerm', 'currency', 'creator', 'poItems.product', 'poItems.uom', 'supplierInvoices'])->find($id);
        if (!$po) {
            return response()->json(['message' => 'Purchase order not found'], 404);
        }
        return response()->json($po);
    }

    public function purchaseOrderItems($id)
    {
        $po = PurchaseOrder::with(['poItems.product', 'poItems.uom'])->find($id);
        if (!$po) {
            return response()->json(['message' => 'Purchase order not found'], 404);
        }
        return response()->json($po->poItems);
    }

    public function supplierInvoices()
    {
        $invoices = SupplierInvoice::with(['supplier', 'purchaseOrder'])->get();
        return response()->json($invoices);
    }

    public function currencies()
    {
        return response()->json(Currency::all());
    }

    public function paymentTerms()
    {
        return response()->json(PaymentTerm::all());
    }

    public function uom()
    {
        return response()->json(UnitOfMeasure::all());
    }

    public function addresses()
    {
        return response()->json(Address::all());
    }
}
