@extends('layouts.erp')

@section('breadcrumb', 'Suplier Management')

@section('content')
    <div class="max-w-4xl mx-auto bg-white border rounded-2xl p-8">
        <h1 class="text-2xl font-bold mb-1">Add new supplier</h1>
        <p class="text-gray-500 mb-6">Fill in the details to register a new supplier.</p>

        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                {{-- Company Information --}}
                <div class="border rounded-xl p-4">
                    <h2 class="font-semibold mb-3">Company Information</h2>
                    <div class="space-y-3 text-sm">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-gray-500 mb-1">Company Name *</label>
                                <input name="company_name" type="text" placeholder="Enter company name" class="w-full border rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">Business Type *</label>
                                <select name="business_type" class="w-full border rounded-lg px-3 py-2">
                                    <option value="">Select business type</option>
                                    <option>Farm</option>
                                    <option>Cooperative</option>
                                    <option>Distributor</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Address *</label>
                            <textarea name="address" placeholder="Enter complete address" class="w-full border rounded-lg px-3 py-2" rows="2"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-gray-500 mb-1">Phone Number *</label>
                                <input name="phone" type="text" placeholder="Enter phone number" class="w-full border rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">Email Address *</label>
                                <input name="email" type="email" placeholder="Enter email address" class="w-full border rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Primary Contact --}}
                <div class="border rounded-xl p-4">
                    <h2 class="font-semibold mb-3">Primary Contact</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="block text-gray-500 mb-1">Contact Person *</label>
                            <input name="contact_person" type="text" placeholder="Enter contact person name" class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Position / Designation *</label>
                            <input name="position" type="text" placeholder="Enter position" class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Phone Number *</label>
                            <input name="contact_phone" type="text" placeholder="Enter phone number" class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Email Address *</label>
                            <input name="contact_email" type="email" placeholder="Enter email address" class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Delivery Information --}}
                <div class="border rounded-xl p-4">
                    <h2 class="font-semibold mb-3">Delivery Information</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="block text-gray-500 mb-1">Lead Time *</label>
                            <select name="lead_time" class="w-full border rounded-lg px-3 py-2">
                                <option>2-3 Business Days</option>
                                <option>1-2 Business Days</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Delivery Schedule *</label>
                            <select name="delivery_schedule" class="w-full border rounded-lg px-3 py-2">
                                <option>Monday - Saturday</option>
                                <option>Weekdays only</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-500 mb-1">Minimum Order Quantity *</label>
                            <select name="moq" class="w-full border rounded-lg px-3 py-2">
                                <option>10 Sacks</option>
                                <option>5 Sacks</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Product Supplied + Payment --}}
                <div class="space-y-6">
                    <div class="border rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Product Supplied</h2>
                        <label class="block text-gray-500 mb-2 text-sm">Select product supplied *</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="checkbox" name="products[]" value="Rice"> Rice</label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="products[]" value="Vegetables"> Vegetables</label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="products[]" value="Fruits"> Fruits</label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="products[]" value="Others"> Others</label>
                        </div>
                    </div>

                    <div class="border rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Payment Information</h2>
                        <div class="space-y-3 text-sm">
                            <div>
                                <label class="block text-gray-500 mb-1">Payment Terms *</label>
                                <select name="payment_terms" class="w-full border rounded-lg px-3 py-2">
                                    <option value="">Select payment terms</option>
                                    <option>Net 15</option>
                                    <option>Net 30</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">Payment Method *</label>
                                <select name="payment_method" class="w-full border rounded-lg px-3 py-2">
                                    <option value="">Select payment method</option>
                                    <option>Bank Transfer</option>
                                    <option>Cash</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border rounded-xl p-4">
                <h2 class="font-semibold mb-2">Description</h2>
                <textarea name="description" maxlength="1000" placeholder="Add description about your growing business..." class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
                <div class="text-right text-xs text-gray-400 mt-1">0/1000</div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('suppliers.index') }}" class="px-4 py-2 rounded-lg border text-sm">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-green-700 text-white text-sm">Save Supplier</button>
            </div>
        </form>
    </div>
@endsection
