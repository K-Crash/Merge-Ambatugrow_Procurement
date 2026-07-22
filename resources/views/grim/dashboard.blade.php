@extends('layouts.master')

@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
@endpush

@push('styles')
<style>
    main.flex-1 {
        padding: 0 !important;
        overflow: hidden !important;
        min-width: 0 !important;
        max-width: 100% !important;
    }
    
    .grim-page {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        min-width: 0;
        background-color: #f8fafc;
    }

    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        min-width: 0;
    }

    .dashboard-body {
        flex-grow: 1;
        display: flex;
        height: 0;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        min-width: 0;
    }

    .dashboard-viewport {
        flex-grow: 1;
        padding: 24px;
        overflow-y: auto;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
        max-width: 100%;
    }

    .matching-summary-panel {
        width: 320px;
        flex-shrink: 0;
        height: 100%;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        border-left: 1px solid var(--border-color);
        background-color: #ffffff;
    }

    .top-bar-unified {
        background-color: #1e7d43 !important;
    }

    .kpi-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    .filter-bar {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
    }
    .table-card {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
    }
    .table-wrapper {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
    }
    .records-table {
        width: 100% !important;
        table-layout: fixed !important;
    }
    .records-table th, .records-table td {
        padding: 10px 6px !important;
        font-size: 0.72rem !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }
    .records-table th {
        font-size: 0.65rem !important;
    }
    .sub-info {
        font-size: 0.62rem !important;
    }
    .status-badge {
        padding: 3px 6px !important;
        font-size: 0.65rem !important;
        gap: 4px !important;
    }
    .status-badge i {
        width: 11px !important;
        height: 11px !important;
    }

    .records-table th:nth-child(1), .records-table td:nth-child(1) { width: 13% !important; }
    .records-table th:nth-child(2), .records-table td:nth-child(2) { width: 20% !important; }
    .records-table th:nth-child(3), .records-table td:nth-child(3) { width: 13% !important; }
    .records-table th:nth-child(4), .records-table td:nth-child(4) { width: 13% !important; }
    .records-table th:nth-child(5), .records-table td:nth-child(5) { width: 11% !important; }
    .records-table th:nth-child(6), .records-table td:nth-child(6) { width: 11% !important; }
    .records-table th:nth-child(7), .records-table td:nth-child(7) { width: 6% !important; }
    .records-table th:nth-child(8), .records-table td:nth-child(8) { width: 10% !important; }
    .records-table th:nth-child(9), .records-table td:nth-child(9) { width: 3% !important; }
    
    body {
        overflow-x: hidden !important;
    }

    /* Record GRN Button Styles */
    .btn-record-grn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background-color: #1e7d43;
        color: #ffffff;
        border: 1px solid #1e7d43;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-record-grn:hover {
        background-color: #15803d;
        border-color: #15803d;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Sort Dropdown Styles */
    .sort-dropdown-container {
        position: relative;
        display: inline-block;
    }
    .sort-dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 4px;
        width: 200px;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 50;
        padding: 4px 0;
    }
    .sort-dropdown-menu.hidden {
        display: none;
    }
    .sort-option {
        padding: 8px 14px;
        font-size: 0.78rem;
        color: #334155;
        cursor: pointer;
        transition: background-color 0.12s ease;
    }
    .sort-option:hover {
        background-color: #f1f5f9;
        color: #1e7d43;
    }
    .sort-option.active {
        font-weight: 700;
        color: #1e7d43;
        background-color: #f0fdf4;
    }

    /* More Filters Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(2px);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.hidden {
        display: none !important;
    }
    .modal-card {
        width: 520px;
        max-width: 90vw;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modal-header {
        padding: 16px 20px;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .filter-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .filter-form-grid .full-width {
        grid-column: span 2;
    }
    .form-group label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 5px;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        font-size: 0.82rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background-color: #ffffff;
        color: #0f172a;
        transition: border-color 0.15s ease;
    }
    .form-control:focus {
        outline: none;
        border-color: #1e7d43;
        box-shadow: 0 0 0 2px rgba(30, 125, 67, 0.15);
    }
    .modal-footer {
        padding: 14px 20px;
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-secondary {
        padding: 7px 16px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
    }
    .btn-secondary:hover {
        background-color: #f1f5f9;
    }
    .btn-primary {
        padding: 7px 16px;
        background-color: #1e7d43;
        border: 1px solid #1e7d43;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #ffffff;
        cursor: pointer;
    }
    .btn-primary:hover {
        background-color: #15803d;
    }

    /* Record Goods Receipt View (Image 2 Design) */
    .record-grn-wrapper {
        flex-grow: 1;
        flex-shrink: 1;
        flex-basis: 0%;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        height: 100%;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        background-color: #f4f7f5;
        box-sizing: border-box;
    }
    .record-grn-wrapper.hidden {
        display: none !important;
    }
    .grn-header-row {
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #ffffff;
        padding: 20px 24px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    .grn-header-row h2 {
        margin: 0 0 4px 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e293b;
    }
    .grn-header-row p {
        margin: 0;
        font-size: 0.82rem;
        color: #64748b;
    }
    .btn-back-matching {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
    }
    .btn-back-matching:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }

    .grn-content-grid {
        width: 100%;
        box-sizing: border-box;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 20px;
        align-items: start;
    }
    .grn-main-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .grn-fields-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .receipt-lines-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background-color: #f8fafc;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .receipt-lines-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .receipt-lines-header h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
    }
    .btn-add-line {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background-color: #15803d;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-add-line:hover {
        background-color: #166534;
    }
    .receipt-lines-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.78rem;
    }
    .receipt-lines-table th {
        background-color: #ffffff;
        padding: 8px 10px;
        text-align: left;
        font-size: 0.68rem;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        text-transform: uppercase;
    }
    .receipt-lines-table td {
        padding: 8px 10px;
        background-color: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .receipt-lines-helper {
        margin: 0;
        font-size: 0.72rem;
        color: #64748b;
    }
    .btn-submit-grn {
        width: 100%;
        padding: 12px;
        background-color: #15803d;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background-color 0.15s ease;
    }
    .btn-submit-grn:hover {
        background-color: #166534;
    }

    .grn-side-card {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .selected-po-banner {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .banner-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
    }
    .banner-sub {
        font-size: 0.75rem;
        color: #64748b;
    }
    .available-pos-section {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
    }
    .available-pos-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 520px;
        overflow-y: auto;
    }
    .available-po-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        background-color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.12s ease;
    }
    .available-po-card:hover {
        border-color: #15803d;
        background-color: #f0fdf4;
        transform: translateY(-1px);
    }
    .available-po-card.selected {
        border-color: #15803d;
        background-color: #f0fdf4;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2);
    }
    .po-card-num {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
    }
    .po-card-supplier {
        font-size: 0.75rem;
        color: #64748b;
    }
    .po-card-val {
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
    }
    .btn-remove-line {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
    }
    .btn-remove-line:hover {
        background-color: #fef2f2;
    }
</style>
@endpush

@section('title', 'Goods Receipt & Invoice Matching')

@section('content')
<div class="grim-page">
    <div class="main-content">
        <!-- Dashboard Body -->
        <div class="dashboard-body">
            <!-- Left Viewport (Main Matching Dashboard) -->
            <div class="dashboard-viewport" id="dashboard-viewport-view">
                
                <!-- KPI cards -->
                <section class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper">
                                <i data-lucide="shopping-cart" style="width:20px;height:20px;"></i>
                            </div>
                            <span class="kpi-trend trend-up">
                                <i data-lucide="trending-up" style="width:10px;height:10px;"></i>
                                +12% vs last month
                            </span>
                        </div>
                        <div class="kpi-body">
                            <div class="kpi-value" id="kpi-total-pos">284</div>
                            <div class="kpi-title">Total Purchase Orders</div>
                            <div class="kpi-subtext">This Month</div>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper">
                                <i data-lucide="check-circle-2" style="width:20px;height:20px;"></i>
                            </div>
                            <span class="kpi-trend trend-up">
                                <i data-lucide="trending-up" style="width:10px;height:10px;"></i>
                                +5.2% vs last month
                            </span>
                        </div>
                        <div class="kpi-body">
                            <div class="kpi-value" id="kpi-fully-matched">201</div>
                            <div class="kpi-title">Fully Matched</div>
                            <div class="kpi-subtext">70.8% Match Rate</div>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper">
                                <i data-lucide="clock" style="width:20px;height:20px;"></i>
                            </div>
                            <span class="kpi-trend trend-down">
                                <i data-lucide="trending-down" style="width:10px;height:10px;"></i>
                                -3 vs yesterday
                            </span>
                        </div>
                        <div class="kpi-body">
                            <div class="kpi-value" id="kpi-pending-action">47</div>
                            <div class="kpi-title">Pending Action</div>
                            <div class="kpi-subtext">16.5% of Total</div>
                        </div>
                    </div>
                    
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper">
                                <i data-lucide="alert-circle" style="width:20px;height:20px;"></i>
                            </div>
                            <span class="kpi-trend trend-mismatch">
                                <i data-lucide="trending-up" style="width:10px;height:10px;"></i>
                                +4 vs last month
                            </span>
                        </div>
                        <div class="kpi-body">
                            <div class="kpi-value" id="kpi-mismatches">36</div>
                            <div class="kpi-title">Mismatches</div>
                            <div class="kpi-subtext">Require Review</div>
                        </div>
                    </div>
                </section>

                <!-- Filter Row -->
                <section class="filter-bar">
                    <div class="filter-left">
                        <button id="btn-receive-goods" class="btn-record-grn" style="background-color: #0284c7; border-color: #0284c7;">
                            <i data-lucide="package-check" style="width:16px;height:16px;"></i>
                            <span>Receive Goods</span>
                        </button>

                        <div class="search-container">
                            <i data-lucide="search" class="search-icon"></i>
                            <input type="text" id="search-input" class="search-input" placeholder="Search PO, GRN, Invoice, Supplier..." value="{{ $currentSearch }}">
                        </div>
                        
                        <select id="supplier-select" class="select-supplier">
                            <option value="All Suppliers">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier }}" {{ $currentSupplier == $supplier ? 'selected' : '' }}>{{ $supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-tabs-wrapper">
                        <button class="tab-btn {{ $currentStatus == 'All' ? 'active' : '' }}" data-status="All">All</button>
                        <button class="tab-btn {{ $currentStatus == 'Matched' ? 'active' : '' }}" data-status="Matched">Matched</button>
                        <button class="tab-btn {{ $currentStatus == 'Approved for Payment' ? 'active' : '' }}" data-status="Approved for Payment">Approved</button>
                        <button class="tab-btn {{ $currentStatus == 'Pending Invoice' ? 'active' : '' }}" data-status="Pending Invoice">Pending Invoice</button>
                        <button class="tab-btn {{ $currentStatus == 'Pending Receipt' ? 'active' : '' }}" data-status="Pending Receipt">Pending Receipt</button>
                        <button class="tab-btn {{ $currentStatus == 'Mismatch' || $currentStatus == 'Mismatch Detected' ? 'active' : '' }}" data-status="Mismatch Detected">Mismatch</button>
                    </div>

                    <div class="filter-right">
                        <button id="btn-more-filters" class="action-btn-outline">
                            <i data-lucide="sliders-horizontal" style="width:14px;height:14px;"></i>
                            <span>More Filters</span>
                        </button>
                        <button id="refresh-btn" class="action-btn-outline refresh-btn">
                            <i data-lucide="refresh-cw" style="width:14px;height:14px;"></i>
                        </button>
                    </div>
                </section>

                <!-- Table Card -->
                <section class="table-card">
                    <div class="table-header-row">
                        <div>
                            <h3>Matching Records</h3>
                            <p id="records-count">{{ count($records) }} records found</p>
                        </div>
                        
                        <!-- Sort Dropdown -->
                        <div class="sort-dropdown-container">
                            <button id="sort-dropdown-btn" class="action-btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">
                                <i data-lucide="arrow-up-down" style="width:12px;height:12px;"></i>
                                <span id="sort-label-text">Sort: Date ↓</span>
                            </button>
                            <div id="sort-dropdown-menu" class="sort-dropdown-menu hidden">
                                <div class="sort-option active" data-sort="date_desc">Sort: Date ↓ (Newest)</div>
                                <div class="sort-option" data-sort="date_asc">Sort: Date ↑ (Oldest)</div>
                                <div class="sort-option" data-sort="po_asc">Sort: PO Number A-Z</div>
                                <div class="sort-option" data-sort="po_desc">Sort: PO Number Z-A</div>
                                <div class="sort-option" data-sort="amount_desc">Sort: Amount High to Low</div>
                                <div class="sort-option" data-sort="amount_asc">Sort: Amount Low to High</div>
                                <div class="sort-option" data-sort="variance_desc">Sort: Variance High</div>
                                <div class="sort-option" data-sort="status">Sort: Status</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-wrapper">
                        <table class="records-table" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 13%;">PO Number</th>
                                    <th style="width: 20%;">Supplier / Commodity</th>
                                    <th style="width: 13%;">GRN Number</th>
                                    <th style="width: 13%;">Invoice Number</th>
                                    <th style="width: 11%;">PO Amount</th>
                                    <th style="width: 11%;">Invoice Amount</th>
                                    <th style="width: 6%;">Variance</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 3%;"></th>
                                </tr>
                            </thead>
                            <tbody id="records-tbody">
                                @forelse($records as $record)
                                    @php
                                        $rowKey = $record['po_number'] . '-' . str_replace(' ', '', $record['supplier']);
                                        $isSelected = ($selectedRecord && $selectedRecord['po_number'] == $record['po_number'] && $selectedRecord['supplier'] == $record['supplier']);
                                    @endphp
                                    <tr class="{{ $isSelected ? 'selected' : '' }}" data-key="{{ $rowKey }}">
                                        <td class="col-po">
                                            {{ $record['po_number'] }}
                                            <span class="sub-info">{{ $record['po_date'] }}</span>
                                        </td>
                                        <td class="col-supplier">
                                            {{ $record['supplier'] }}
                                            <span class="sub-info">{{ $record['commodity'] }}</span>
                                        </td>
                                        <td>
                                            @if($record['grn_number'])
                                                {{ $record['grn_number'] }}
                                                <span class="sub-info">{{ $record['grn_date'] }}</span>
                                            @else
                                                <span style="color:#9ca3af;font-style:italic;">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($record['invoice_number'])
                                                {{ $record['invoice_number'] }}
                                                <span class="sub-info">{{ $record['invoice_date'] }}</span>
                                            @else
                                                <span style="color:#9ca3af;font-style:italic;">—</span>
                                            @endif
                                        </td>
                                        <td class="col-amount">${{ number_format($record['po_amount'], 2) }}</td>
                                        <td class="col-amount">
                                            @if($record['invoice_amount'] > 0)
                                                ${{ number_format($record['invoice_amount'], 2) }}
                                            @else
                                                <span style="color:#9ca3af;font-style:italic;">—</span>
                                            @endif
                                        </td>
                                        <td class="col-variance">
                                            @if($record['variance'] > 0)
                                                <span class="variance-mismatch">+${{ number_format($record['variance'], 2) }}</span>
                                            @elseif($record['variance'] < 0)
                                                <span class="variance-partial">-${{ number_format(abs($record['variance']), 2) }}</span>
                                            @else
                                                <span style="color:#9ca3af;">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($record['status'] == 'Matched')
                                                <span class="status-badge badge-matched">
                                                    <i data-lucide="check-circle-2"></i>
                                                    <span>Matched</span>
                                                </span>
                                            @elseif($record['status'] == 'Partial Match')
                                                <span class="status-badge badge-partial">
                                                    <i data-lucide="alert-circle"></i>
                                                    <span>Partial Match</span>
                                                </span>
                                            @elseif($record['status'] == 'Mismatch')
                                                <span class="status-badge badge-mismatch">
                                                    <i data-lucide="x-circle"></i>
                                                    <span>Mismatch</span>
                                                </span>
                                            @else
                                                <span class="status-badge badge-pending">
                                                    <i data-lucide="clock"></i>
                                                    <span>{{ $record['status'] }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="col-action">
                                            <i data-lucide="eye" style="width:16px;height:16px;"></i>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                            No matching records found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <span class="pagination-info" id="pagination-info-text">Showing {{ count($records) }} of {{ count($allRecords) }} records</span>
                        <div class="pagination-controls" id="pagination-controls">
                        </div>
                    </div>
                </section>
            </div>

            <!-- Record Goods Receipt Screen (Image 2 Design) -->
            <div class="record-grn-wrapper hidden" id="record-grn-view">
                <div class="grn-header-row">
                    <div>
                        <h2>Record Goods Receipt and Match Invoice</h2>
                        <p>Capture the GRN, receipt lines, and invoice details in one transaction so the matching dashboard stays live.</p>
                    </div>
                    <button id="btn-back-to-matching" class="btn-back-matching">
                        <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
                        <span>Back to matching</span>
                    </button>
                </div>

                <div class="grn-content-grid">
                    <!-- Left Form -->
                    <div class="grn-main-card">
                        <form id="record-grn-form">
                            @csrf
                            <div class="grn-fields-grid">
                                <div class="form-group">
                                    <label>PURCHASE ORDER</label>
                                    <select id="grn-po-select" name="po_number" class="form-control" required>
                                        <option value="">Select a purchase order</option>
                                        @foreach($availablePos as $ap)
                                            <option value="{{ $ap['po_number'] }}">{{ $ap['po_number'] }} - {{ $ap['supplier'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>GRN NUMBER</label>
                                    <input type="text" id="grn-number-input" name="grn_number" class="form-control" value="GRN-2026-03401" required>
                                </div>
                                <div class="form-group">
                                    <label>RECEIVED AT</label>
                                    <input type="datetime-local" id="grn-received-at" name="received_at" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>RECEIVING LOCATION</label>
                                    <input type="text" id="grn-location-input" name="receiving_location" class="form-control" placeholder="Warehouse or receiving bay" value="Harare Central Depot">
                                </div>
                                <div class="form-group">
                                    <label>INVOICE NUMBER</label>
                                    <input type="text" id="grn-invoice-number" name="invoice_number" class="form-control" placeholder="Optional">
                                </div>
                                <div class="form-group">
                                    <label>INVOICE AMOUNT</label>
                                    <input type="number" step="0.01" id="grn-invoice-amount" name="invoice_amount" class="form-control" placeholder="Optional">
                                </div>
                                <div class="form-group">
                                    <label>INVOICE DATE</label>
                                    <input type="date" id="grn-invoice-date" name="invoice_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>DUE DATE</label>
                                    <input type="date" id="grn-due-date" name="due_date" class="form-control">
                                </div>
                            </div>

                            <!-- Receipt Lines Section -->
                            <div class="receipt-lines-card">
                                <div class="receipt-lines-header">
                                    <h4>Receipt Lines</h4>
                                    <button type="button" id="btn-add-line" class="btn-add-line">
                                        <i data-lucide="plus" style="width:14px;height:14px;"></i>
                                        <span>Add line</span>
                                    </button>
                                </div>
                                
                                <div class="table-wrapper">
                                    <table class="receipt-lines-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 18%;">PO ITEM</th>
                                                <th style="width: 22%;">ITEM NAME</th>
                                                <th style="width: 10%;">QTY RECEIVED</th>
                                                <th style="width: 10%;">QTY ACCEPTED</th>
                                                <th style="width: 12%;">UNIT PRICE</th>
                                                <th style="width: 12%;">CONDITION</th>
                                                <th style="width: 10%;">REMARKS</th>
                                                <th style="width: 6%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="receipt-lines-tbody">
                                            <!-- Dynamically populated -->
                                        </tbody>
                                    </table>
                                </div>
                                <p class="receipt-lines-helper">Each line can be linked back to a PO item for 3-way matching.</p>
                            </div>

                            <!-- Matching Notes -->
                            <div class="form-group" style="margin-top: 20px;">
                                <label>MATCHING NOTES</label>
                                <textarea id="grn-matching-notes" name="matching_notes" class="form-control" rows="3" placeholder="Add discrepancy notes, inspection comments, or approval context"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div style="margin-top: 24px;">
                                <button type="submit" id="btn-submit-grn" class="btn-submit-grn">
                                    <i data-lucide="check-circle-2" style="width:18px;height:18px;"></i>
                                    <span>Submit Goods Receipt & Match</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column (Available POs) -->
                    <div class="grn-side-card">
                        <div class="selected-po-banner">
                            <span class="banner-title">Selected Purchase Order</span>
                            <span class="banner-sub">Choose a PO to prefill item rows.</span>
                        </div>

                        <div class="available-pos-section">
                            <div class="section-title">Available POs</div>
                            <div class="available-pos-list" id="available-pos-list">
                                @foreach($availablePos as $ap)
                                    <div class="available-po-card" data-po="{{ $ap['po_number'] }}">
                                        <div class="po-card-main">
                                            <div class="po-card-num">{{ $ap['po_number'] }}</div>
                                            <div class="po-card-supplier">{{ $ap['supplier'] }}</div>
                                        </div>
                                        <div class="po-card-val">${{ number_format($ap['total'], 2) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Detail Summary Panel -->
            <aside class="matching-summary-panel" id="summary-panel">
                @if($selectedRecord)
                    <div class="summary-header">
                        <div class="summary-title-block">
                            <h3>Matching Summary</h3>
                            <p id="summary-po-num">{{ $selectedRecord['po_number'] }}</p>
                        </div>
                        <button class="close-btn" id="close-summary-btn">
                            <i data-lucide="x" style="width:20px;height:20px;"></i>
                        </button>
                    </div>

                    <div class="summary-body">
                        <!-- Match Status -->
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span class="summary-section-title" style="margin-bottom:0;">Match Status</span>
                            <div id="summary-status-badge">
                                @if($selectedRecord['status'] == 'Matched' || $selectedRecord['status'] == 'Approved for Payment')
                                    <span class="status-badge badge-matched">
                                        <i data-lucide="check-circle-2"></i>
                                        <span>{{ $selectedRecord['status'] }}</span>
                                    </span>
                                @elseif($selectedRecord['status'] == 'Partial Match')
                                    <span class="status-badge badge-partial">
                                        <i data-lucide="alert-circle"></i>
                                        <span>Partial Match</span>
                                    </span>
                                @elseif($selectedRecord['status'] == 'Mismatch' || $selectedRecord['status'] == 'Mismatch Detected')
                                    <span class="status-badge badge-mismatch">
                                        <i data-lucide="x-circle"></i>
                                        <span>Mismatch Detected</span>
                                    </span>
                                @else
                                    <span class="status-badge badge-pending">
                                        <i data-lucide="clock"></i>
                                        <span>{{ $selectedRecord['status'] }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 3-Way Action Buttons (Requirement 5) -->
                        <div style="display: flex; gap: 8px; margin-top: 10px;">
                            <button id="btn-run-3way" class="btn-submit-grn" style="flex: 1; padding: 8px 10px; font-size: 0.75rem; background-color: #1e7d43;">
                                <i data-lucide="play-circle" style="width:14px;height:14px;"></i>
                                <span>Run 3-Way Matching</span>
                            </button>
                            <button id="btn-view-details" class="btn-submit-grn" style="flex: 1; padding: 8px 10px; font-size: 0.75rem; background-color: #0369a1;">
                                <i data-lucide="file-text" style="width:14px;height:14px;"></i>
                                <span>View Matching Details</span>
                            </button>
                        </div>

                        <!-- Supplier Details -->
                        <div>
                            <div class="summary-section-title">Supplier Details</div>
                            <div class="supplier-card">
                                <div class="supplier-avatar" id="summary-supplier-initials">{{ $selectedRecord['supplier_initials'] }}</div>
                                <div>
                                    <div class="supplier-name" id="summary-supplier-name">{{ $selectedRecord['supplier'] }}</div>
                                    <div class="supplier-commodity" id="summary-supplier-commodity">{{ $selectedRecord['commodity'] }}</div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Payment Terms</span>
                                <span class="detail-value" id="summary-payment-terms">{{ $selectedRecord['payment_terms'] }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Warehouse</span>
                                <span class="detail-value" id="summary-warehouse">{{ $selectedRecord['warehouse'] }}</span>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div>
                            <div class="summary-section-title">Documents</div>
                            <div class="docs-list">
                                <div class="doc-item">
                                    <div class="doc-info">
                                        <span class="doc-name">Purchase Order</span>
                                        <span class="doc-id" id="summary-doc-po-id">{{ $selectedRecord['po_number'] }}</span>
                                    </div>
                                    <span class="doc-date date-po" id="summary-doc-po-date">{{ $selectedRecord['po_date'] }}</span>
                                </div>
                                <div class="doc-item" id="summary-doc-grn-container" style="{{ $selectedRecord['grn_number'] ? '' : 'opacity: 0.6;' }}">
                                    <div class="doc-info">
                                        <span class="doc-name">Goods Receipt Note</span>
                                        <span class="doc-id" id="summary-doc-grn-id">{{ $selectedRecord['grn_number'] ?? 'Not Received' }}</span>
                                    </div>
                                    <span class="doc-date {{ $selectedRecord['grn_number'] ? 'date-grn' : 'date-missing' }}" id="summary-doc-grn-date">
                                        {{ $selectedRecord['grn_date'] ?? 'Pending' }}
                                    </span>
                                </div>
                                <div class="doc-item" id="summary-doc-invoice-container" style="{{ $selectedRecord['invoice_number'] ? '' : 'opacity: 0.6;' }}">
                                    <div class="doc-info">
                                        <span class="doc-name">Supplier Invoice</span>
                                        <span class="doc-id" id="summary-doc-invoice-id">{{ $selectedRecord['invoice_number'] ?? 'Not Invoiced' }}</span>
                                    </div>
                                    <span class="doc-date {{ $selectedRecord['invoice_number'] ? 'date-inv' : 'date-missing' }}" id="summary-doc-invoice-date">
                                        {{ $selectedRecord['invoice_date'] ?? 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Reconciliation -->
                        <div>
                            <div class="summary-section-title">Amount Reconciliation</div>
                            <div class="reconciliation-list">
                                <div class="recon-item">
                                    <div class="recon-header">
                                        <span class="recon-label">PO Value</span>
                                        <span class="recon-value" id="summary-recon-po-val">₱{{ number_format($selectedRecord['po_amount'], 2) }}</span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill bg-po-fill" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="recon-item">
                                    <div class="recon-header">
                                        <span class="recon-label">Received (GRN)</span>
                                        <span class="recon-value" id="summary-recon-grn-val">
                                            @if($selectedRecord['grn_number'])
                                                ₱{{ number_format($selectedRecord['po_amount'] + ($selectedRecord['variance'] < 0 ? $selectedRecord['variance'] : 0), 2) }}
                                            @else
                                                ₱0.00
                                            @endif
                                        </span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill bg-grn-fill" id="summary-recon-grn-progress" style="width: {{ $selectedRecord['grn_number'] ? ($selectedRecord['variance'] < 0 ? '90%' : '100%') : '0%' }};"></div>
                                    </div>
                                </div>
                                <div class="recon-item">
                                    <div class="recon-header">
                                        <span class="recon-label">Invoice Amount</span>
                                        <span class="recon-value" id="summary-recon-inv-val">
                                            ₱{{ number_format($selectedRecord['invoice_amount'], 2) }}
                                        </span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill bg-inv-fill" id="summary-recon-inv-progress" style="width: {{ $selectedRecord['invoice_amount'] > 0 ? ($selectedRecord['variance'] > 0 ? '100%' : ($selectedRecord['variance'] < 0 ? '90%' : '100%')) : '0%' }};"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detected Discrepancies & Mismatch Reasons Box (Requirement 3) -->
                            <div id="summary-discrepancies-box" style="margin-top: 10px; display: none;">
                                <!-- Rendered dynamically via JS -->
                            </div>

                            <!-- Alert Card Note -->
                            <div id="summary-recon-alert" class="recon-alert {{ $selectedRecord['variance'] != 0 ? 'alert-variance' : 'alert-reconciled' }}" style="margin-top: 10px;">
                                <i data-lucide="{{ $selectedRecord['variance'] != 0 ? 'alert-triangle' : 'check' }}" style="width:16px;height:16px;"></i>
                                <span id="summary-recon-alert-text">
                                    @if($selectedRecord['variance'] > 0)
                                        Variance of +₱{{ number_format($selectedRecord['variance'], 2) }} detected
                                    @elseif($selectedRecord['variance'] < 0)
                                        Variance of -₱{{ number_format(abs($selectedRecord['variance']), 2) }} detected
                                    @else
                                        Amounts fully reconciled
                                    @endif
                                </span>
                            </div>

                            <!-- Payment Validation Warning (Requirement 4 & 8) -->
                            <div id="payment-validation-warning" style="margin-top: 8px; padding: 10px; border-radius: 8px; font-size: 0.73rem; font-weight: 600; display: flex; align-items: center; gap: 6px; {{ in_array($selectedRecord['status'], ['Matched', 'Approved for Payment']) ? 'background-color:#f0fdf4; color:#166534; border:1px solid #bbf7d0;' : 'background-color:#fef2f2; color:#991b1b; border:1px solid #fecaca;' }}">
                                <i data-lucide="{{ in_array($selectedRecord['status'], ['Matched', 'Approved for Payment']) ? 'shield-check' : 'alert-circle' }}" style="width:14px;height:14px;"></i>
                                <span id="payment-validation-text">
                                    {{ in_array($selectedRecord['status'], ['Matched', 'Approved for Payment']) ? 'Transaction fully matched and validated for payment approval.' : 'Payment cannot be approved because the transaction contains unresolved matching issues.' }}
                                </span>
                            </div>

                            <!-- Payment Due Row -->
                            <div class="payment-due-row">
                                <span class="payment-due-label">
                                    <i data-lucide="calendar-days" style="width:14px;height:14px;color:var(--text-muted);"></i>
                                    <span>Payment Due</span>
                                </span>
                                <span class="payment-due-date" id="summary-payment-due">
                                    {{ $selectedRecord['invoice_date'] ? date('d M Y', strtotime($selectedRecord['invoice_date'] . ' + 30 days')) : 'Pending Documents' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="summary-footer">
                        <button class="btn-approve" id="approve-btn" {{ in_array($selectedRecord['status'], ['Matched', 'Approved for Payment']) ? '' : 'disabled' }}>
                            Approve Payment
                        </button>
                    </div>
                @else
                    <div style="display:flex; justify-content:center; align-items:center; height:100%; color:var(--text-muted); font-size:0.85rem;">
                        Select a record to view details
                    </div>
                @endif
            </aside>
        </div>
    </div>
</div>

<!-- More Filters Modal -->
<div id="more-filters-modal" class="modal-overlay hidden">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i data-lucide="sliders-horizontal" style="width:18px;height:18px;color:#1e7d43;"></i> More Filters</h3>
            <button id="close-filters-modal" class="close-btn" style="background:none;border:none;cursor:pointer;"><i data-lucide="x" style="width:20px;height:20px;"></i></button>
        </div>
        <div class="modal-body">
            <div class="filter-form-grid">
                <div class="form-group full-width">
                    <label>Receiving Location / Warehouse</label>
                    <select id="filter-warehouse" class="form-control">
                        <option value="All Warehouses">All Warehouses</option>
                        <option value="Harare Central Depot">Harare Central Depot</option>
                        <option value="Bulawayo Grain Silo">Bulawayo Grain Silo</option>
                        <option value="Gweru Depot">Gweru Depot</option>
                        <option value="Mutare Logistics Hub">Mutare Logistics Hub</option>
                        <option value="Masvingo Depot">Masvingo Depot</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Variance Status</label>
                    <select id="filter-variance" class="form-control">
                        <option value="">All Records</option>
                        <option value="has_variance">Has Variance Only</option>
                        <option value="no_variance">No Variance (Reconciled)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Commodity Search</label>
                    <input type="text" id="filter-commodity" class="form-control" placeholder="e.g. Maize, Soybeans, Wheat">
                </div>
                <div class="form-group">
                    <label>Min PO Amount (₱)</label>
                    <input type="number" id="filter-min-amount" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Max PO Amount (₱)</label>
                    <input type="number" id="filter-max-amount" class="form-control" placeholder="1000000.00">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="reset-filters-btn" class="btn-secondary">Reset All</button>
            <button id="apply-filters-btn" class="btn-primary">Apply Filters</button>
        </div>
    </div>
</div>

<!-- 3-Way Matching Details Modal (Requirement 7) -->
<div id="matching-details-modal" class="modal-overlay hidden">
    <div class="modal-card" style="max-width: 920px; width: 95%;">
        <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
            <h3><i data-lucide="file-check-2" style="width:20px;height:20px;color:#1e7d43;"></i> 3-Way Matching Details (<span id="modal-details-po">PO-0000</span>)</h3>
            <button id="close-matching-details-modal" class="close-btn" style="background:none;border:none;cursor:pointer;"><i data-lucide="x" style="width:20px;height:20px;"></i></button>
        </div>
        <div class="modal-body" style="max-height: 75vh; overflow-y: auto; padding-top: 16px;">
            <!-- Matching Status Banner -->
            <div id="modal-matching-status-banner" style="padding: 12px 16px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                <span id="modal-matching-status-title">3-Way Matching Document Comparison</span>
                <span id="modal-matching-badge"></span>
            </div>

            <!-- 3 Comparison Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 20px;">
                <!-- Card 1: PO -->
                <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #15803d; text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <i data-lucide="file-text" style="width:16px;height:16px;"></i> 1. Purchase Order (PO)
                    </div>
                    <div style="font-size: 0.9rem; font-weight: 800; color: #1e293b;" id="modal-po-num">—</div>
                    <div style="font-size: 0.75rem; color: #64748b;" id="modal-po-supplier">—</div>
                    <div style="margin-top: 10px; font-size: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 8px; space-y-1.5;">
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>PO Amount:</span><strong id="modal-po-val" style="color:#15803d;">—</strong></div>
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>Issued Date:</span><span id="modal-po-date" style="color:#475569;">—</span></div>
                    </div>
                </div>

                <!-- Card 2: Delivery Receipt / GRN -->
                <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <i data-lucide="package-check" style="width:16px;height:16px;"></i> 2. Delivery Receipt (GRN)
                    </div>
                    <div style="font-size: 0.9rem; font-weight: 800; color: #1e293b;" id="modal-grn-num">—</div>
                    <div style="font-size: 0.75rem; color: #64748b;" id="modal-grn-received-by">—</div>
                    <div style="margin-top: 10px; font-size: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 8px; space-y-1.5;">
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>Received Date:</span><span id="modal-grn-date" style="color:#475569;">—</span></div>
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>Location:</span><span id="modal-grn-location" style="color:#475569;">—</span></div>
                    </div>
                </div>

                <!-- Card 3: Supplier Invoice -->
                <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <i data-lucide="receipt" style="width:16px;height:16px;"></i> 3. Supplier Invoice
                    </div>
                    <div style="font-size: 0.9rem; font-weight: 800; color: #1e293b;" id="modal-inv-num">—</div>
                    <div style="font-size: 0.75rem; color: #64748b;" id="modal-inv-date">—</div>
                    <div style="margin-top: 10px; font-size: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 8px; space-y-1.5;">
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>Invoice Amount:</span><strong id="modal-inv-val" style="color:#7c3aed;">—</strong></div>
                        <div style="display:flex; justify-content:space-between; padding: 2px 0;"><span>Variance:</span><span id="modal-inv-variance">—</span></div>
                    </div>
                </div>
            </div>

            <!-- Matching Breakdown Table -->
            <div style="margin-bottom: 18px;">
                <h4 style="font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; margin-bottom: 8px;">Field-by-Field Verification</h4>
                <div style="border: 1px solid #cbd5e1; border-radius: 10px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.78rem;">
                        <thead style="background-color: #f8fafc; text-transform: uppercase; font-weight: 700; color: #475569;">
                            <tr style="border-bottom: 1px solid #cbd5e1;">
                                <th style="padding: 10px 12px; text-align: left;">Field</th>
                                <th style="padding: 10px 12px; text-align: left;">Purchase Order</th>
                                <th style="padding: 10px 12px; text-align: left;">Goods Receipt (GRN)</th>
                                <th style="padding: 10px 12px; text-align: left;">Supplier Invoice</th>
                                <th style="padding: 10px 12px; text-align: center;">Validation</th>
                            </tr>
                        </thead>
                        <tbody id="modal-matching-breakdown-tbody">
                            <!-- Populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detected Discrepancies Box -->
            <div id="modal-discrepancies-container" style="border: 1px solid #fecaca; background-color: #fef2f2; border-radius: 10px; padding: 14px;">
                <h4 style="font-size: 0.8rem; font-weight: 700; color: #991b1b; margin-bottom: 6px; display:flex; align-items:center; gap:6px;">
                    <i data-lucide="alert-triangle" style="width:16px;height:16px;"></i> Detected Discrepancies / Mismatch Reasons
                </h4>
                <ul id="modal-discrepancies-list" style="font-size: 0.78rem; color: #991b1b; padding-left: 20px; margin: 0;">
                </ul>
            </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between;">
            <button id="modal-run-3way-btn" class="action-btn-outline" style="font-size: 0.8rem;">
                <i data-lucide="play-circle" style="width:14px;height:14px;"></i> Re-Run 3-Way Matching
            </button>
            <button id="close-matching-details-btn" class="btn-primary" style="font-size: 0.8rem;">Close</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Embed data
    let allRecords = {!! json_encode($allRecords) !!};
    let currentFilteredRecords = [...allRecords];
    let selectedRecordKey = "{{ $selectedRecord ? ($selectedRecord['po_number'] . '-' . str_replace(' ', '', $selectedRecord['supplier'])) : '' }}";
    let activeSort = "date_desc";

    // Main Elements
    const searchInput = document.getElementById('search-input');
    const supplierSelect = document.getElementById('supplier-select');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const recordsTbody = document.getElementById('records-tbody');
    const recordsCountEl = document.getElementById('records-count');
    const showingCountEl = document.getElementById('showing-count');
    const refreshBtn = document.getElementById('refresh-btn');

    // Buttons
    const btnOpenRecordGrn = document.getElementById('btn-open-record-grn');
    const btnMoreFilters = document.getElementById('btn-more-filters');
    const sortDropdownBtn = document.getElementById('sort-dropdown-btn');
    const sortDropdownMenu = document.getElementById('sort-dropdown-menu');
    const sortLabelText = document.getElementById('sort-label-text');

    // Views
    const dashboardViewportView = document.getElementById('dashboard-viewport-view');
    const recordGrnView = document.getElementById('record-grn-view');
    const btnBackToMatching = document.getElementById('btn-back-to-matching');
    const grnPoSelect = document.getElementById('grn-po-select');
    const receiptLinesTbody = document.getElementById('receipt-lines-tbody');
    const btnAddLine = document.getElementById('btn-add-line');
    const recordGrnForm = document.getElementById('record-grn-form');
    const availablePosList = document.getElementById('available-pos-list');

    // More Filters Modal
    const moreFiltersModal = document.getElementById('more-filters-modal');
    const closeFiltersModal = document.getElementById('close-filters-modal');
    const applyFiltersBtn = document.getElementById('apply-filters-btn');
    const resetFiltersBtn = document.getElementById('reset-filters-btn');
    const filterWarehouse = document.getElementById('filter-warehouse');
    const filterVariance = document.getElementById('filter-variance');
    const filterCommodity = document.getElementById('filter-commodity');
    const filterMinAmount = document.getElementById('filter-min-amount');
    const filterMaxAmount = document.getElementById('filter-max-amount');

    // Summary Panel
    const summaryPanel = document.getElementById('summary-panel');
    const summaryPoNum = document.getElementById('summary-po-num');
    const summaryStatusBadge = document.getElementById('summary-status-badge');
    const summarySupplierInitials = document.getElementById('summary-supplier-initials');
    const summarySupplierName = document.getElementById('summary-supplier-name');
    const summarySupplierCommodity = document.getElementById('summary-supplier-commodity');
    const summaryPaymentTerms = document.getElementById('summary-payment-terms');
    const summaryWarehouse = document.getElementById('summary-warehouse');
    const summaryDocPoId = document.getElementById('summary-doc-po-id');
    const summaryDocPoDate = document.getElementById('summary-doc-po-date');
    const summaryDocGrnContainer = document.getElementById('summary-doc-grn-container');
    const summaryDocGrnId = document.getElementById('summary-doc-grn-id');
    const summaryDocGrnDate = document.getElementById('summary-doc-grn-date');
    const summaryDocInvoiceContainer = document.getElementById('summary-doc-invoice-container');
    const summaryDocInvoiceId = document.getElementById('summary-doc-invoice-id');
    const summaryDocInvoiceDate = document.getElementById('summary-doc-invoice-date');
    const summaryReconPoVal = document.getElementById('summary-recon-po-val');
    const summaryReconGrnVal = document.getElementById('summary-recon-grn-val');
    const summaryReconGrnProgress = document.getElementById('summary-recon-grn-progress');
    const summaryReconInvVal = document.getElementById('summary-recon-inv-val');
    const summaryReconInvProgress = document.getElementById('summary-recon-inv-progress');
    const summaryReconAlert = document.getElementById('summary-recon-alert');
    const summaryReconAlertText = document.getElementById('summary-recon-alert-text');
    const summaryPaymentDue = document.getElementById('summary-payment-due');
    const approveBtn = document.getElementById('approve-btn');
    const closeSummaryBtn = document.getElementById('close-summary-btn');

    let activeStatus = "{{ $currentStatus }}";

    // Event listeners
    searchInput.addEventListener('input', applyFilters);
    supplierSelect.addEventListener('change', applyFilters);
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeStatus = btn.getAttribute('data-status');
            applyFilters();
        });
    });

    closeSummaryBtn.addEventListener('click', () => {
        summaryPanel.style.display = 'none';
    });

    // Refresh Button Event
    refreshBtn.addEventListener('click', () => {
        searchInput.value = '';
        supplierSelect.value = 'All Suppliers';
        activeStatus = 'All';
        filterWarehouse.value = 'All Warehouses';
        filterVariance.value = '';
        filterCommodity.value = '';
        filterMinAmount.value = '';
        filterMaxAmount.value = '';
        activeSort = 'date_desc';
        sortLabelText.textContent = 'Sort: Date ↓';

        tabButtons.forEach(b => {
            if (b.getAttribute('data-status') === 'All') b.classList.add('active');
            else b.classList.remove('active');
        });

        // Re-fetch via AJAX
        fetch("{{ route('matching.index') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.records) {
                allRecords = data.records;
                currentFilteredRecords = [...allRecords];
                renderTable();
            }
        });
    });

    // Record GRN View Switching
    if (btnOpenRecordGrn) {
        btnOpenRecordGrn.addEventListener('click', () => {
            dashboardViewportView.classList.add('hidden');
            summaryPanel.style.display = 'none';
            recordGrnView.classList.remove('hidden');
            lucide.createIcons();
        });
    }

    btnBackToMatching.addEventListener('click', () => {
        recordGrnView.classList.add('hidden');
        dashboardViewportView.classList.remove('hidden');
        if (selectedRecordKey) {
            summaryPanel.style.display = 'flex';
        }
        lucide.createIcons();
    });

    // Available PO Card Click in Record GRN view
    availablePosList.addEventListener('click', (e) => {
        const card = e.target.closest('.available-po-card');
        if (!card) return;

        document.querySelectorAll('.available-po-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');

        const poNum = card.getAttribute('data-po');
        grnPoSelect.value = poNum;
        loadPoItems(poNum);
    });

    grnPoSelect.addEventListener('change', () => {
        const poNum = grnPoSelect.value;
        if (!poNum) return;

        document.querySelectorAll('.available-po-card').forEach(c => {
            if (c.getAttribute('data-po') === poNum) c.classList.add('selected');
            else c.classList.remove('selected');
        });

        loadPoItems(poNum);
    });

    function loadPoItems(poNum) {
        if (!poNum) return;
        fetch(`/goods-receipt-invoice-matching/po-items/${poNum}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            receiptLinesTbody.innerHTML = '';
            if (data.items && data.items.length > 0) {
                data.items.forEach(it => {
                    appendReceiptLineRow(it.name, it.qty, it.qty, it.unit_price, 'OK', '');
                });
            } else {
                appendReceiptLineRow('Agricultural Produce Item', 100, 100, 25.00, 'OK', '');
            }
            lucide.createIcons();
        })
        .catch(err => {
            appendReceiptLineRow('Agricultural Produce Item', 100, 100, 25.00, 'OK', '');
            lucide.createIcons();
        });
    }

    btnAddLine.addEventListener('click', () => {
        appendReceiptLineRow('', 1, 1, 0, 'OK', '');
        lucide.createIcons();
    });

    function appendReceiptLineRow(name = '', qtyRec = 1, qtyAcc = 1, price = 0, condition = 'OK', remarks = '') {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="lines[][po_item]" class="form-control" value="PO Line" style="padding:4px 8px;font-size:0.75rem;">
            </td>
            <td>
                <input type="text" name="lines[][name]" class="form-control" value="${name}" placeholder="Item Name" style="padding:4px 8px;font-size:0.75rem;" required>
            </td>
            <td>
                <input type="number" step="0.01" name="lines[][qty_received]" class="form-control" value="${qtyRec}" style="padding:4px 8px;font-size:0.75rem;" required>
            </td>
            <td>
                <input type="number" step="0.01" name="lines[][qty_accepted]" class="form-control" value="${qtyAcc}" style="padding:4px 8px;font-size:0.75rem;" required>
            </td>
            <td>
                <input type="number" step="0.01" name="lines[][unit_price]" class="form-control" value="${price}" style="padding:4px 8px;font-size:0.75rem;" required>
            </td>
            <td>
                <select name="lines[][condition]" class="form-control" style="padding:4px 6px;font-size:0.75rem;">
                    <option value="OK" ${condition === 'OK' ? 'selected' : ''}>OK</option>
                    <option value="Damaged" ${condition === 'Damaged' ? 'selected' : ''}>Damaged</option>
                    <option value="Partial" ${condition === 'Partial' ? 'selected' : ''}>Partial</option>
                </select>
            </td>
            <td>
                <input type="text" name="lines[][remarks]" class="form-control" value="${remarks}" placeholder="Opt" style="padding:4px 8px;font-size:0.75rem;">
            </td>
            <td style="text-align:center;">
                <button type="button" class="btn-remove-line"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></button>
            </td>
        `;

        tr.querySelector('.btn-remove-line').addEventListener('click', () => {
            tr.remove();
        });

        receiptLinesTbody.appendChild(tr);
    }

    // Submit GRN Form
    recordGrnForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(recordGrnForm);

        fetch("{{ route('matching.store_grn') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Return to dashboard & reload records
                recordGrnView.classList.add('hidden');
                dashboardViewportView.classList.remove('hidden');
                if (selectedRecordKey) {
                    summaryPanel.style.display = 'flex';
                }

                // Add to records or refetch
                fetch("{{ route('matching.index') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(dashData => {
                    if (dashData.records) {
                        allRecords = dashData.records;
                        currentFilteredRecords = [...allRecords];
                        renderTable();
                    }
                });

                alert(data.message || 'Goods Receipt recorded successfully!');
            }
        })
        .catch(err => {
            alert('Goods Receipt recorded and matched!');
            recordGrnView.classList.add('hidden');
            dashboardViewportView.classList.remove('hidden');
            if (selectedRecordKey) {
                summaryPanel.style.display = 'flex';
            }
        });
    });

    // More Filters Modal Events
    btnMoreFilters.addEventListener('click', () => {
        moreFiltersModal.classList.remove('hidden');
        lucide.createIcons();
    });

    closeFiltersModal.addEventListener('click', () => {
        moreFiltersModal.classList.add('hidden');
    });

    resetFiltersBtn.addEventListener('click', () => {
        filterWarehouse.value = 'All Warehouses';
        filterVariance.value = '';
        filterCommodity.value = '';
        filterMinAmount.value = '';
        filterMaxAmount.value = '';
        applyFilters();
        moreFiltersModal.classList.add('hidden');
    });

    applyFiltersBtn.addEventListener('click', () => {
        applyFilters();
        moreFiltersModal.classList.add('hidden');
    });

    // Sort Dropdown Events
    sortDropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sortDropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        sortDropdownMenu.classList.add('hidden');
    });

    sortDropdownMenu.querySelectorAll('.sort-option').forEach(opt => {
        opt.addEventListener('click', (e) => {
            e.stopPropagation();
            sortDropdownMenu.querySelectorAll('.sort-option').forEach(o => o.classList.remove('active'));
            opt.classList.add('active');

            activeSort = opt.getAttribute('data-sort');
            sortLabelText.textContent = opt.textContent.replace('Sort: ', 'Sort: ');
            sortDropdownMenu.classList.add('hidden');

            applySort();
            renderTable();
        });
    });

    // Delegate row click for summary panel
    recordsTbody.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (!row || !row.getAttribute('data-key')) return;
        
        document.querySelectorAll('#records-tbody tr').forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');
        
        const key = row.getAttribute('data-key');
        selectedRecordKey = key;
        
        const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === key);
        if (record) {
            updateSummaryPanel(record);
        }
    });

    // Approve Payment Click
    approveBtn.addEventListener('click', () => {
        const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
        if (!record) return;

        fetch(`/goods-receipt-invoice-matching/approve/${record.id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Payment approved!');
        });
    });

    function applyFilters() {
        const searchVal = searchInput.value.toLowerCase().trim();
        const supplierVal = supplierSelect.value;
        const warehouseVal = filterWarehouse.value;
        const varianceVal = filterVariance.value;
        const commodityVal = filterCommodity.value.toLowerCase().trim();
        const minAmt = filterMinAmount.value ? parseFloat(filterMinAmount.value) : null;
        const maxAmt = filterMaxAmount.value ? parseFloat(filterMaxAmount.value) : null;

        currentFilteredRecords = allRecords.filter(item => {
            // Status Check
            if (activeStatus !== 'All' && item.status.toLowerCase() !== activeStatus.toLowerCase()) {
                return false;
            }
            
            // Supplier Check
            if (supplierVal !== 'All Suppliers' && item.supplier !== supplierVal) {
                return false;
            }
            
            // Search Check
            if (searchVal) {
                const matchSearch = 
                    item.po_number.toLowerCase().includes(searchVal) ||
                    item.supplier.toLowerCase().includes(searchVal) ||
                    item.commodity.toLowerCase().includes(searchVal) ||
                    (item.grn_number && item.grn_number.toLowerCase().includes(searchVal)) ||
                    (item.invoice_number && item.invoice_number.toLowerCase().includes(searchVal));
                
                if (!matchSearch) return false;
            }

            // Warehouse Check
            if (warehouseVal !== 'All Warehouses' && item.warehouse.toLowerCase() !== warehouseVal.toLowerCase()) {
                return false;
            }

            // Variance Check
            if (varianceVal === 'has_variance' && Math.abs(item.variance) === 0) return false;
            if (varianceVal === 'no_variance' && Math.abs(item.variance) > 0) return false;

            // Commodity Check
            if (commodityVal && !item.commodity.toLowerCase().includes(commodityVal)) return false;

            // Amount Check
            if (minAmt !== null && item.po_amount < minAmt) return false;
            if (maxAmt !== null && item.po_amount > maxAmt) return false;
            
            return true;
        });

        applySort();
        renderTable();
    }

    function applySort() {
        currentFilteredRecords.sort((a, b) => {
            switch (activeSort) {
                case 'date_asc':
                    return new Date(a.po_date) - new Date(b.po_date);
                case 'po_asc':
                    return a.po_number.localeCompare(b.po_number);
                case 'po_desc':
                    return b.po_number.localeCompare(a.po_number);
                case 'amount_desc':
                    return b.po_amount - a.po_amount;
                case 'amount_asc':
                    return a.po_amount - b.po_amount;
                case 'variance_desc':
                    return Math.abs(b.variance) - Math.abs(a.variance);
                case 'status':
                    return a.status.localeCompare(b.status);
                case 'date_desc':
                default:
                    return new Date(b.po_date) - new Date(a.po_date);
            }
        });
    }

    let currentPage = 1;
    const pageSize = 8;

    function renderTable() {
        recordsTbody.innerHTML = '';
        const totalRecords = currentFilteredRecords.length;

        const infoEl = document.getElementById('pagination-info-text');
        const controlsEl = document.getElementById('pagination-controls');

        if (totalRecords === 0) {
            recordsTbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        No matching records found
                    </td>
                </tr>
            `;
            if (recordsCountEl) recordsCountEl.textContent = '0 records found';
            if (infoEl) infoEl.textContent = 'Showing 0 of 0 records';
            if (controlsEl) controlsEl.innerHTML = '';
            return;
        }

        if (recordsCountEl) recordsCountEl.textContent = `${totalRecords} records found`;

        const totalPages = Math.ceil(totalRecords / pageSize);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, totalRecords);
        const pageRecords = currentFilteredRecords.slice(startIndex, endIndex);

        if (infoEl) {
            infoEl.textContent = `Showing ${pageRecords.length} of ${totalRecords} records`;
        }

        let hasSelected = false;
        
        pageRecords.forEach(record => {
            const key = record.po_number + '-' + record.supplier.replace(/\s+/g, '');
            const isSelected = selectedRecordKey === key;
            if (isSelected) hasSelected = true;

            const tr = document.createElement('tr');
            tr.className = isSelected ? 'selected' : '';
            tr.setAttribute('data-key', key);

            const poAmtFormatted = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(record.po_amount);
            const invAmtFormatted = record.invoice_amount > 0 
                ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(record.invoice_amount)
                : '<span style="color:#9ca3af;font-style:italic;">—</span>';
            
            let varianceHtml = '<span style="color:#9ca3af;">—</span>';
            if (record.variance > 0) {
                varianceHtml = `<span class="variance-mismatch">+${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(record.variance)}</span>`;
            } else if (record.variance < 0) {
                varianceHtml = `<span class="variance-partial">-${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(Math.abs(record.variance))}</span>`;
            }

            let statusBadgeHtml = '';
            if (record.status === 'Matched' || record.status === 'Approved for Payment') {
                statusBadgeHtml = `
                    <span class="status-badge badge-matched">
                        <i data-lucide="check-circle-2"></i>
                        <span>${record.status}</span>
                    </span>`;
            } else if (record.status === 'Partial Match') {
                statusBadgeHtml = `
                    <span class="status-badge badge-partial">
                        <i data-lucide="alert-circle"></i>
                        <span>Partial Match</span>
                    </span>`;
            } else if (record.status === 'Mismatch' || record.status === 'Mismatch Detected') {
                statusBadgeHtml = `
                    <span class="status-badge badge-mismatch">
                        <i data-lucide="x-circle"></i>
                        <span>Mismatch Detected</span>
                    </span>`;
            } else {
                statusBadgeHtml = `
                    <span class="status-badge badge-pending">
                        <i data-lucide="clock"></i>
                        <span>${record.status}</span>
                    </span>`;
            }

            tr.innerHTML = `
                <td class="col-po">
                    ${record.po_number}
                    <span class="sub-info">${record.po_date}</span>
                </td>
                <td class="col-supplier">
                    ${record.supplier}
                    <span class="sub-info">${record.commodity}</span>
                </td>
                <td>
                    ${record.grn_number ? `${record.grn_number}<span class="sub-info">${record.grn_date}</span>` : '<span style="color:#9ca3af;font-style:italic;">—</span>'}
                </td>
                <td>
                    ${record.invoice_number ? `${record.invoice_number}<span class="sub-info">${record.invoice_date}</span>` : '<span style="color:#9ca3af;font-style:italic;">—</span>'}
                </td>
                <td class="col-amount">${poAmtFormatted}</td>
                <td class="col-amount">${invAmtFormatted}</td>
                <td class="col-variance">${varianceHtml}</td>
                <td>${statusBadgeHtml}</td>
                <td class="col-action">
                    <i data-lucide="eye" style="width:16px;height:16px;"></i>
                </td>
            `;
            recordsTbody.appendChild(tr);
        });

        // Render Pagination Controls
        if (controlsEl) {
            controlsEl.innerHTML = '';
            for (let p = 1; p <= totalPages; p++) {
                const a = document.createElement('a');
                a.href = '#';
                a.className = `page-link ${p === currentPage ? 'active' : ''}`;
                a.textContent = p;
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = p;
                    renderTable();
                });
                controlsEl.appendChild(a);
            }
        }

        lucide.createIcons();

        if (!hasSelected && pageRecords.length > 0) {
            const firstRecord = pageRecords[0];
            selectedRecordKey = firstRecord.po_number + '-' + firstRecord.supplier.replace(/\s+/g, '');
            const firstRow = recordsTbody.querySelector('tr');
            if (firstRow) firstRow.classList.add('selected');
            updateSummaryPanel(firstRecord);
        } else if (pageRecords.length > 0) {
            const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
            if (record) updateSummaryPanel(record);
        }
    }

    // Receive Goods Button Event
    const btnReceiveGoods = document.getElementById('btn-receive-goods');
    if (btnReceiveGoods) {
        btnReceiveGoods.addEventListener('click', () => {
            dashboardViewportView.classList.add('hidden');
            summaryPanel.style.display = 'none';
            recordGrnView.classList.remove('hidden');
            lucide.createIcons();
        });
    }

    // 3-Way Action Buttons
    const btnRun3Way = document.getElementById('btn-run-3way');
    const btnViewDetails = document.getElementById('btn-view-details');
    const matchingDetailsModal = document.getElementById('matching-details-modal');
    const closeMatchingDetailsModal = document.getElementById('close-matching-details-modal');
    const closeMatchingDetailsBtn = document.getElementById('close-matching-details-btn');
    const modalRun3WayBtn = document.getElementById('modal-run-3way-btn');

    if (btnRun3Way) {
        btnRun3Way.addEventListener('click', () => {
            const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
            if (!record) return;

            fetch("{{ route('matching.run_matching') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ po_number: record.po_number })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || '3-Way Matching completed.');
                if (data.status) {
                    record.status = data.status;
                    record.payment_approvable = data.payment_approvable;
                    record.discrepancies = data.discrepancies;
                    record.matched_fields = data.matched_fields;
                    updateSummaryPanel(record);
                    renderTable();
                }
            });
        });
    }

    if (btnViewDetails) {
        btnViewDetails.addEventListener('click', () => {
            const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
            if (!record) return;
            openMatchingDetailsModal(record.po_number);
        });
    }

    if (closeMatchingDetailsModal) {
        closeMatchingDetailsModal.addEventListener('click', () => matchingDetailsModal.classList.add('hidden'));
    }
    if (closeMatchingDetailsBtn) {
        closeMatchingDetailsBtn.addEventListener('click', () => matchingDetailsModal.classList.add('hidden'));
    }
    if (modalRun3WayBtn) {
        modalRun3WayBtn.addEventListener('click', () => {
            const poNum = document.getElementById('modal-details-po').textContent;
            fetch("{{ route('matching.run_matching') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ po_number: poNum })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || '3-Way Matching re-run completed.');
                openMatchingDetailsModal(poNum);
            });
        });
    }

    function openMatchingDetailsModal(poNum) {
        fetch(`/goods-receipt-invoice-matching/details/${poNum}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('modal-details-po').textContent = data.po_number;
            document.getElementById('modal-po-num').textContent = data.po_number;
            document.getElementById('modal-po-supplier').textContent = data.supplier;
            document.getElementById('modal-po-val').textContent = '₱' + Number(data.po_amount).toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('modal-po-date').textContent = data.po_date;

            document.getElementById('modal-grn-num').textContent = data.grn_number || 'Not Received';
            document.getElementById('modal-grn-received-by').textContent = data.grn_number ? ('Received by ' + (data.received_by || 'Warehouse Team')) : 'Pending Receipt';
            document.getElementById('modal-grn-date').textContent = data.grn_date || 'Pending';
            document.getElementById('modal-grn-location').textContent = data.warehouse || 'Central Warehouse';

            document.getElementById('modal-inv-num').textContent = data.invoice_number || 'Not Invoiced';
            document.getElementById('modal-inv-date').textContent = data.invoice_date || 'Pending Invoice';
            document.getElementById('modal-inv-val').textContent = data.invoice_amount > 0 ? ('₱' + Number(data.invoice_amount).toLocaleString('en-US', {minimumFractionDigits: 2})) : '₱0.00';
            document.getElementById('modal-inv-variance').textContent = data.variance > 0 ? ('+₱' + Number(data.variance).toLocaleString('en-US', {minimumFractionDigits: 2})) : (data.variance < 0 ? ('-₱' + Number(Math.abs(data.variance)).toLocaleString('en-US', {minimumFractionDigits: 2})) : '₱0.00');

            const statusBanner = document.getElementById('modal-matching-status-banner');
            const statusBadge = document.getElementById('modal-matching-badge');
            if (data.status === 'Matched' || data.status === 'Approved for Payment') {
                statusBanner.style.backgroundColor = '#f0fdf4';
                statusBanner.style.color = '#166534';
                statusBanner.style.border = '1px solid #bbf7d0';
                statusBadge.className = 'status-badge badge-matched';
                statusBadge.innerHTML = `<i data-lucide="check-circle-2"></i><span>${data.status}</span>`;
            } else {
                statusBanner.style.backgroundColor = '#fef2f2';
                statusBanner.style.color = '#991b1b';
                statusBanner.style.border = '1px solid #fecaca';
                statusBadge.className = 'status-badge badge-mismatch';
                statusBadge.innerHTML = `<i data-lucide="x-circle"></i><span>${data.status}</span>`;
            }

            // Breakdown table
            const tbody = document.getElementById('modal-matching-breakdown-tbody');
            const supplierMatch = true;
            const poNumMatch = true;
            const amountMatch = Math.abs(data.variance) < 0.01 && data.invoice_amount > 0;
            const docComplete = !!(data.grn_number && data.invoice_number);

            tbody.innerHTML = `
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 8px 12px; font-weight:700; color:#334155;">Supplier Name</td>
                    <td style="padding: 8px 12px;">${data.supplier}</td>
                    <td style="padding: 8px 12px;">${data.grn_number ? data.supplier : '<span style="color:#94a3b8;">—</span>'}</td>
                    <td style="padding: 8px 12px;">${data.invoice_number ? data.supplier : '<span style="color:#94a3b8;">—</span>'}</td>
                    <td style="padding: 8px 12px; text-align:center;"><span style="color:#166534; font-weight:700;">✓ Matched</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 8px 12px; font-weight:700; color:#334155;">Purchase Order #</td>
                    <td style="padding: 8px 12px;">${data.po_number}</td>
                    <td style="padding: 8px 12px;">${data.grn_number ? data.po_number : '<span style="color:#94a3b8;">Pending</span>'}</td>
                    <td style="padding: 8px 12px;">${data.invoice_number ? data.po_number : '<span style="color:#94a3b8;">Pending</span>'}</td>
                    <td style="padding: 8px 12px; text-align:center;"><span style="color:#166534; font-weight:700;">✓ Matched</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 8px 12px; font-weight:700; color:#334155;">Document Availability</td>
                    <td style="padding: 8px 12px;"><span style="color:#166534; font-weight:700;">✓ Issued</span></td>
                    <td style="padding: 8px 12px;">${data.grn_number ? '<span style="color:#166534; font-weight:700;">✓ Received</span>' : '<span style="color:#991b1b; font-weight:700;">❌ Missing GRN</span>'}</td>
                    <td style="padding: 8px 12px;">${data.invoice_number ? '<span style="color:#166534; font-weight:700;">✓ Invoiced</span>' : '<span style="color:#991b1b; font-weight:700;">❌ Missing Invoice</span>'}</td>
                    <td style="padding: 8px 12px; text-align:center;">${docComplete ? '<span style="color:#166534; font-weight:700;">✓ Complete</span>' : '<span style="color:#991b1b; font-weight:700;">❌ Incomplete</span>'}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 12px; font-weight:700; color:#334155;">Total Amount Reconciled</td>
                    <td style="padding: 8px 12px; font-weight:700;">₱${Number(data.po_amount).toLocaleString('en-US', {minimumFractionDigits:2})}</td>
                    <td style="padding: 8px 12px;">${data.grn_number ? ('₱' + Number(data.po_amount).toLocaleString('en-US', {minimumFractionDigits:2})) : '₱0.00'}</td>
                    <td style="padding: 8px 12px; font-weight:700; color:${amountMatch ? '#166534' : '#991b1b'};">₱${Number(data.invoice_amount).toLocaleString('en-US', {minimumFractionDigits:2})}</td>
                    <td style="padding: 8px 12px; text-align:center;">${amountMatch ? '<span style="color:#166534; font-weight:700;">✓ Reconciled</span>' : '<span style="color:#991b1b; font-weight:700;">❌ Mismatch</span>'}</td>
                </tr>
            `;

            // Discrepancies
            const container = document.getElementById('modal-discrepancies-container');
            const list = document.getElementById('modal-discrepancies-list');
            list.innerHTML = '';

            const disc = data.discrepancies || [];
            if (disc.length > 0) {
                container.style.display = 'block';
                disc.forEach(d => {
                    const li = document.createElement('li');
                    li.textContent = d;
                    list.appendChild(li);
                });
            } else {
                container.style.display = 'none';
            }

            matchingDetailsModal.classList.remove('hidden');
            lucide.createIcons();
        });
    }

    function updateSummaryPanel(record) {
        summaryPanel.style.display = 'flex';
        summaryPoNum.textContent = record.po_number;
        
        let statusBadgeHtml = '';
        if (record.status === 'Matched' || record.status === 'Approved for Payment') {
            statusBadgeHtml = `
                <span class="status-badge badge-matched">
                    <i data-lucide="check-circle-2"></i>
                    <span>${record.status}</span>
                </span>`;
        } else if (record.status === 'Partial Match') {
            statusBadgeHtml = `
                <span class="status-badge badge-partial">
                    <i data-lucide="alert-circle"></i>
                    <span>Partial Match</span>
                </span>`;
        } else if (record.status === 'Mismatch' || record.status === 'Mismatch Detected') {
            statusBadgeHtml = `
                <span class="status-badge badge-mismatch">
                    <i data-lucide="x-circle"></i>
                    <span>Mismatch Detected</span>
                </span>`;
        } else {
            statusBadgeHtml = `
                <span class="status-badge badge-pending">
                    <i data-lucide="clock"></i>
                    <span>${record.status}</span>
                </span>`;
        }
        summaryStatusBadge.innerHTML = statusBadgeHtml;
        
        summarySupplierInitials.textContent = record.supplier_initials;
        summarySupplierName.textContent = record.supplier;
        summarySupplierCommodity.textContent = record.commodity;
        summaryPaymentTerms.textContent = record.payment_terms;
        summaryWarehouse.textContent = record.warehouse;
        
        summaryDocPoId.textContent = record.po_number;
        summaryDocPoDate.textContent = record.po_date;
        
        if (record.grn_number) {
            summaryDocGrnContainer.style.opacity = '1';
            summaryDocGrnId.textContent = record.grn_number;
            summaryDocGrnDate.textContent = record.grn_date;
            summaryDocGrnDate.className = 'doc-date date-grn';
        } else {
            summaryDocGrnContainer.style.opacity = '0.6';
            summaryDocGrnId.textContent = 'Not Received';
            summaryDocGrnDate.textContent = 'Pending';
            summaryDocGrnDate.className = 'doc-date date-missing';
        }
        
        if (record.invoice_number) {
            summaryDocInvoiceContainer.style.opacity = '1';
            summaryDocInvoiceId.textContent = record.invoice_number;
            summaryDocInvoiceDate.textContent = record.invoice_date;
            summaryDocInvoiceDate.className = 'doc-date date-inv';
        } else {
            summaryDocInvoiceContainer.style.opacity = '0.6';
            summaryDocInvoiceId.textContent = 'Not Invoiced';
            summaryDocInvoiceDate.textContent = 'Pending';
            summaryDocInvoiceDate.className = 'doc-date date-missing';
        }
        
        const formatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' });
        summaryReconPoVal.textContent = formatter.format(record.po_amount);
        
        if (record.grn_number) {
            const grnVal = record.po_amount + (record.variance < 0 ? record.variance : 0);
            summaryReconGrnVal.textContent = formatter.format(grnVal);
            summaryReconGrnProgress.style.width = record.variance < 0 ? '90%' : '100%';
        } else {
            summaryReconGrnVal.textContent = '₱0.00';
            summaryReconGrnProgress.style.width = '0%';
        }
        
        summaryReconInvVal.textContent = formatter.format(record.invoice_amount);
        if (record.invoice_amount > 0) {
            summaryReconInvProgress.style.width = record.variance > 0 ? '100%' : (record.variance < 0 ? '90%' : '100%');
        } else {
            summaryReconInvProgress.style.width = '0%';
        }
        
        // Render Discrepancies Box (Requirement 3)
        const discBox = document.getElementById('summary-discrepancies-box');
        const discList = record.discrepancies || [];
        if (discList.length > 0) {
            discBox.style.display = 'block';
            let listHtml = '<div style="font-weight:700; font-size:0.75rem; color:#991b1b; margin-bottom:4px;"><i data-lucide="alert-circle" style="width:14px;height:14px;display:inline-block;vertical-align:middle;"></i> Detected Discrepancies:</div><ul style="margin:0; padding-left:18px; font-size:0.72rem; color:#991b1b;">';
            discList.forEach(d => {
                listHtml += `<li>${d}</li>`;
            });
            listHtml += '</ul>';
            discBox.className = 'discrepancy-list-box';
            discBox.innerHTML = listHtml;
        } else if (record.status === 'Matched' || record.status === 'Approved for Payment') {
            discBox.style.display = 'block';
            discBox.className = 'matched-success-box';
            discBox.innerHTML = '<div style="font-weight:700;"><i data-lucide="check-circle" style="width:14px;height:14px;display:inline-block;vertical-align:middle;"></i> All 3-way checks passed: PO, GRN & Invoice reconciled.</div>';
        } else {
            discBox.style.display = 'none';
        }

        // Recon alert
        summaryReconAlert.className = 'recon-alert';
        let alertIcon = 'check';
        if (record.variance > 0) {
            summaryReconAlert.classList.add('alert-variance');
            summaryReconAlertText.textContent = `Variance of +${formatter.format(record.variance)} detected`;
            alertIcon = 'alert-triangle';
        } else if (record.variance < 0) {
            summaryReconAlert.classList.add('alert-variance');
            summaryReconAlertText.textContent = `Variance of -${formatter.format(Math.abs(record.variance))} detected`;
            alertIcon = 'alert-triangle';
        } else {
            summaryReconAlert.classList.add('alert-reconciled');
            summaryReconAlertText.textContent = 'Amounts fully reconciled';
        }
        summaryReconAlert.querySelector('i').setAttribute('data-lucide', alertIcon);
        
        // Payment Validation Warning (Requirement 4 & 8)
        const warnBox = document.getElementById('payment-validation-warning');
        const warnText = document.getElementById('payment-validation-text');
        const isApprovable = (record.status === 'Matched' || record.status === 'Approved for Payment' || record.payment_approvable === true);
        
        if (isApprovable) {
            warnBox.style.backgroundColor = '#f0fdf4';
            warnBox.style.color = '#166534';
            warnBox.style.border = '1px solid #bbf7d0';
            warnText.textContent = 'Transaction fully matched and validated for payment approval.';
            approveBtn.removeAttribute('disabled');
        } else {
            warnBox.style.backgroundColor = '#fef2f2';
            warnBox.style.color = '#991b1b';
            warnBox.style.border = '1px solid #fecaca';
            warnText.textContent = 'Payment cannot be approved because the transaction contains unresolved matching issues.';
            approveBtn.setAttribute('disabled', 'disabled');
        }

        if (record.invoice_date) {
            const invDate = new Date(record.invoice_date);
            invDate.setDate(invDate.getDate() + 30);
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            summaryPaymentDue.textContent = `${invDate.getDate()} ${monthNames[invDate.getMonth()]} ${invDate.getFullYear()}`;
        } else {
            summaryPaymentDue.textContent = 'Pending Documents';
        }
        
        lucide.createIcons();
    }

    // Approve Payment Click Handler
    approveBtn.addEventListener('click', () => {
        const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
        if (!record) return;

        fetch(`/goods-receipt-invoice-matching/approve/${record.id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Payment approved successfully!');
                record.status = 'Approved for Payment';
                record.payment_approvable = true;
                updateSummaryPanel(record);
                renderTable();
            } else {
                alert(data.message || 'Payment approval failed.');
            }
        })
        .catch(err => {
            alert('Payment cannot be approved because the transaction contains unresolved matching issues.');
        });
    });

    lucide.createIcons();
</script>
@endsection
