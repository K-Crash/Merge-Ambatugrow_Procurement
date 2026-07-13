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
    
    /* Force full-screen fixed dashboard layout with scrollable zones */
    .grim-page {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        min-width: 0;
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

    /* Match the header color of Goods Receipt to other modules (brand green) */
    .top-bar-unified {
        background-color: #1e7d43 !important;
    }

    /* Force all dashboard children to respect boundaries and scroll table horizontally */
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
        overflow-x: hidden !important; /* Make table not scrollable */
    }
    .records-table {
        width: 100% !important;
        table-layout: fixed !important; /* Force exact column widths */
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

    /* Fixed percentage widths for columns to prevent any overflow */
    .records-table th:nth-child(1), .records-table td:nth-child(1) { width: 13% !important; }
    .records-table th:nth-child(2), .records-table td:nth-child(2) { width: 20% !important; }
    .records-table th:nth-child(3), .records-table td:nth-child(3) { width: 13% !important; }
    .records-table th:nth-child(4), .records-table td:nth-child(4) { width: 13% !important; }
    .records-table th:nth-child(5), .records-table td:nth-child(5) { width: 11% !important; }
    .records-table th:nth-child(6), .records-table td:nth-child(6) { width: 11% !important; }
    .records-table th:nth-child(7), .records-table td:nth-child(7) { width: 6% !important; }
    .records-table th:nth-child(8), .records-table td:nth-child(8) { width: 10% !important; }
    .records-table th:nth-child(9), .records-table td:nth-child(9) { width: 3% !important; }
    
    /* Ensure body doesn't overflow horizontally */
    body {
        overflow-x: hidden !important;
    }
</style>
@endpush

@section('title', 'Goods Receipt & Invoice Matching')

@section('content')
<div class="grim-page">
    <div class="main-content">
        <!-- Dashboard Body -->
        <div class="dashboard-body">
            <!-- Left Viewport -->
            <div class="dashboard-viewport">
                
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
                            <div class="kpi-value">284</div>
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
                            <div class="kpi-value">201</div>
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
                            <div class="kpi-value">47</div>
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
                            <div class="kpi-value">36</div>
                            <div class="kpi-title">Mismatches</div>
                            <div class="kpi-subtext">Require Review</div>
                        </div>
                    </div>
                </section>

                <!-- Filter Row -->
                <section class="filter-bar">
                    <div class="filter-left">
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
                        <button class="tab-btn {{ $currentStatus == 'Partial Match' ? 'active' : '' }}" data-status="Partial Match">Partial Match</button>
                        <button class="tab-btn {{ $currentStatus == 'Pending Invoice' ? 'active' : '' }}" data-status="Pending Invoice">Pending Invoice</button>
                        <button class="tab-btn {{ $currentStatus == 'Pending Receipt' ? 'active' : '' }}" data-status="Pending Receipt">Pending Receipt</button>
                        <button class="tab-btn {{ $currentStatus == 'Mismatch' ? 'active' : '' }}" data-status="Mismatch">Mismatch</button>
                    </div>

                    <div class="filter-right">
                        <button class="action-btn-outline">
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
                        <button class="action-btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">
                            <i data-lucide="arrow-up-down" style="width:12px;height:12px;"></i>
                            <span>Sort</span>
                        </button>
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
                        <span class="pagination-info">Showing <span id="showing-count">{{ count($records) }}</span> of 10 records</span>
                        <div class="pagination-controls">
                            <a href="#" class="page-link active">1</a>
                            <a href="#" class="page-link">2</a>
                            <a href="#" class="page-link">3</a>
                            <span style="color:var(--text-muted);padding:0 4px;font-size:0.8rem;">...</span>
                            <a href="#" class="page-link">29</a>
                        </div>
                    </div>
                </section>
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
                                @if($selectedRecord['status'] == 'Matched')
                                    <span class="status-badge badge-matched">
                                        <i data-lucide="check-circle-2"></i>
                                        <span>Matched</span>
                                    </span>
                                @elseif($selectedRecord['status'] == 'Partial Match')
                                    <span class="status-badge badge-partial">
                                        <i data-lucide="alert-circle"></i>
                                        <span>Partial Match</span>
                                    </span>
                                @elseif($selectedRecord['status'] == 'Mismatch')
                                    <span class="status-badge badge-mismatch">
                                        <i data-lucide="x-circle"></i>
                                        <span>Mismatch</span>
                                    </span>
                                @else
                                    <span class="status-badge badge-pending">
                                        <i data-lucide="clock"></i>
                                        <span>{{ $selectedRecord['status'] }}</span>
                                    </span>
                                @endif
                            </div>
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
                                        <span class="recon-value" id="summary-recon-po-val">${{ number_format($selectedRecord['po_amount'], 2) }}</span>
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
                                                ${{ number_format($selectedRecord['po_amount'] + ($selectedRecord['variance'] < 0 ? $selectedRecord['variance'] : 0), 2) }}
                                            @else
                                                $0.00
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
                                            ${{ number_format($selectedRecord['invoice_amount'], 2) }}
                                        </span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill bg-inv-fill" id="summary-recon-inv-progress" style="width: {{ $selectedRecord['invoice_amount'] > 0 ? ($selectedRecord['variance'] > 0 ? '100%' : ($selectedRecord['variance'] < 0 ? '90%' : '100%')) : '0%' }};"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert Card Note -->
                            <div id="summary-recon-alert" class="recon-alert {{ $selectedRecord['variance'] != 0 ? 'alert-variance' : 'alert-reconciled' }}">
                                <i data-lucide="{{ $selectedRecord['variance'] != 0 ? 'alert-triangle' : 'check' }}" style="width:16px;height:16px;"></i>
                                <span id="summary-recon-alert-text">
                                    @if($selectedRecord['variance'] > 0)
                                        Variance of +${{ number_format($selectedRecord['variance'], 2) }} detected
                                    @elseif($selectedRecord['variance'] < 0)
                                        Variance of -${{ number_format(abs($selectedRecord['variance']), 2) }} detected
                                    @else
                                        Amounts fully reconciled
                                    @endif
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
                        <button class="btn-approve" id="approve-btn" {{ $selectedRecord['status'] == 'Matched' ? '' : 'disabled' }}>
                            Approve for Payment
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
@endsection

@section('scripts')
<script>
    // Embed the JSON dump of records for client-side interactions
    const allRecords = {!! json_encode($allRecords) !!};
    let currentFilteredRecords = [...allRecords];
    let selectedRecordKey = "{{ $selectedRecord ? ($selectedRecord['po_number'] . '-' . str_replace(' ', '', $selectedRecord['supplier'])) : '' }}";
    
    // Elements
    const searchInput = document.getElementById('search-input');
    const supplierSelect = document.getElementById('supplier-select');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const recordsTbody = document.getElementById('records-tbody');
    const recordsCountEl = document.getElementById('records-count');
    const showingCountEl = document.getElementById('showing-count');
    const refreshBtn = document.getElementById('refresh-btn');
    
    // Summary Panel Elements
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

    // Filter configuration
    let activeStatus = "{{ $currentStatus }}";
    
    // Register event listeners
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

    refreshBtn.addEventListener('click', () => {
        searchInput.value = '';
        supplierSelect.value = 'All Suppliers';
        activeStatus = 'All';
        tabButtons.forEach(b => {
            if (b.getAttribute('data-status') === 'All') b.classList.add('active');
            else b.classList.remove('active');
        });
        applyFilters();
    });

    // Delegate row click
    recordsTbody.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (!row || !row.getAttribute('data-key')) return;
        
        // Remove selection from previous rows
        document.querySelectorAll('#records-tbody tr').forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');
        
        const key = row.getAttribute('data-key');
        selectedRecordKey = key;
        
        // Find record data
        const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === key);
        if (record) {
            updateSummaryPanel(record);
        }
    });

    function applyFilters() {
        const searchVal = searchInput.value.toLowerCase().trim();
        const supplierVal = supplierSelect.value;
        
        // Filter the array
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
            
            return true;
        });

        // Re-render Table
        renderTable();
    }

    function renderTable() {
        recordsTbody.innerHTML = '';
        
        if (currentFilteredRecords.length === 0) {
            recordsTbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        No matching records found
                    </td>
                </tr>
            `;
            recordsCountEl.textContent = '0 records found';
            showingCountEl.textContent = '0';
            return;
        }

        recordsCountEl.textContent = `${currentFilteredRecords.length} records found`;
        showingCountEl.textContent = currentFilteredRecords.length;

        let hasSelected = false;
        
        currentFilteredRecords.forEach(record => {
            const key = record.po_number + '-' + record.supplier.replace(/\s+/g, '');
            const isSelected = selectedRecordKey === key;
            if (isSelected) hasSelected = true;

            const tr = document.createElement('tr');
            tr.className = isSelected ? 'selected' : '';
            tr.setAttribute('data-key', key);

            // Format numbers
            const poAmtFormatted = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(record.po_amount).replace('$', '$');
            const invAmtFormatted = record.invoice_amount > 0 
                ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(record.invoice_amount)
                : '<span style="color:#9ca3af;font-style:italic;">—</span>';
            
            // Variance formatting
            let varianceHtml = '<span style="color:#9ca3af;">—</span>';
            if (record.variance > 0) {
                varianceHtml = `<span class="variance-mismatch">+${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(record.variance)}</span>`;
            } else if (record.variance < 0) {
                varianceHtml = `<span class="variance-partial">-${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Math.abs(record.variance))}</span>`;
            }

            // Status badges
            let statusBadgeHtml = '';
            if (record.status === 'Matched') {
                statusBadgeHtml = `
                    <span class="status-badge badge-matched">
                        <i data-lucide="check-circle-2"></i>
                        <span>Matched</span>
                    </span>`;
            } else if (record.status === 'Partial Match') {
                statusBadgeHtml = `
                    <span class="status-badge badge-partial">
                        <i data-lucide="alert-circle"></i>
                        <span>Partial Match</span>
                    </span>`;
            } else if (record.status === 'Mismatch') {
                statusBadgeHtml = `
                    <span class="status-badge badge-mismatch">
                        <i data-lucide="x-circle"></i>
                        <span>Mismatch</span>
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

        // Re-initialize icons in the table
        lucide.createIcons();

        // If current selected record is no longer visible, select the first visible row
        if (!hasSelected && currentFilteredRecords.length > 0) {
            const firstRecord = currentFilteredRecords[0];
            selectedRecordKey = firstRecord.po_number + '-' + firstRecord.supplier.replace(/\s+/g, '');
            const firstRow = recordsTbody.querySelector('tr');
            if (firstRow) firstRow.classList.add('selected');
            updateSummaryPanel(firstRecord);
        } else if (currentFilteredRecords.length > 0) {
            // Find active record object
            const record = allRecords.find(r => (r.po_number + '-' + r.supplier.replace(/\s+/g, '')) === selectedRecordKey);
            if (record) updateSummaryPanel(record);
        }
    }

    function updateSummaryPanel(record) {
        summaryPanel.style.display = 'flex';
        summaryPoNum.textContent = record.po_number;
        
        // Status Badge
        let statusBadgeHtml = '';
        if (record.status === 'Matched') {
            statusBadgeHtml = `
                <span class="status-badge badge-matched">
                    <i data-lucide="check-circle-2"></i>
                    <span>Matched</span>
                </span>`;
        } else if (record.status === 'Partial Match') {
            statusBadgeHtml = `
                <span class="status-badge badge-partial">
                    <i data-lucide="alert-circle"></i>
                    <span>Partial Match</span>
                </span>`;
        } else if (record.status === 'Mismatch') {
            statusBadgeHtml = `
                <span class="status-badge badge-mismatch">
                    <i data-lucide="x-circle"></i>
                    <span>Mismatch</span>
                </span>`;
        } else {
            statusBadgeHtml = `
                <span class="status-badge badge-pending">
                    <i data-lucide="clock"></i>
                    <span>${record.status}</span>
                </span>`;
        }
        summaryStatusBadge.innerHTML = statusBadgeHtml;
        
        // Supplier Details
        summarySupplierInitials.textContent = record.supplier_initials;
        summarySupplierName.textContent = record.supplier;
        summarySupplierCommodity.textContent = record.commodity;
        summaryPaymentTerms.textContent = record.payment_terms;
        summaryWarehouse.textContent = record.warehouse;
        
        // Document timeline
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
        
        // Amount Reconciliation
        const formatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' });
        summaryReconPoVal.textContent = formatter.format(record.po_amount);
        
        if (record.grn_number) {
            const grnVal = record.po_amount + (record.variance < 0 ? record.variance : 0);
            summaryReconGrnVal.textContent = formatter.format(grnVal);
            summaryReconGrnProgress.style.width = record.variance < 0 ? '90%' : '100%';
        } else {
            summaryReconGrnVal.textContent = '$0.00';
            summaryReconGrnProgress.style.width = '0%';
        }
        
        summaryReconInvVal.textContent = formatter.format(record.invoice_amount);
        if (record.invoice_amount > 0) {
            summaryReconInvProgress.style.width = record.variance > 0 ? '100%' : (record.variance < 0 ? '90%' : '100%');
        } else {
            summaryReconInvProgress.style.width = '0%';
        }
        
        // Alert box
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
        
        // Payment Due
        if (record.invoice_date) {
            const invDate = new Date(record.invoice_date);
            invDate.setDate(invDate.getDate() + 30);
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            summaryPaymentDue.textContent = `${invDate.getDate()} ${monthNames[invDate.getMonth()]} ${invDate.getFullYear()}`;
        } else {
            summaryPaymentDue.textContent = 'Pending Documents';
        }
        
        // Approve Button
        if (record.status === 'Matched') {
            approveBtn.removeAttribute('disabled');
        } else {
            approveBtn.setAttribute('disabled', 'disabled');
        }
        
        // Re-render icons
        lucide.createIcons();
    }

    // Initialize all icons on page load
    lucide.createIcons();
</script>
@endsection
