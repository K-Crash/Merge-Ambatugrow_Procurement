@extends('layouts.procurement', [
    'pageTitle' => 'Create Purchase Order',
    'workspaceTitle' => 'Create Purchase Order',
    'workspaceSubtitle' => 'Purchase Orders stay visible on the left while you create a new PO on the right.',
    'activePage' => 'create',
])

@section('content')
    <div class="content-layout">
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2>Purchase Orders</h2>
                    <p>The list on the left matches the same visual language as the main purchase page.</p>
                </div>
                <a class="action-link" href="{{ route('procurement.purchase') }}">Open full purchase page</a>
            </div>

            <div class="card-section">
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-label">TOTAL POS</div>
                        <div class="stat-value">4</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">PENDING / DRAFT</div>
                        <div class="stat-value">1</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">ACTIVE / SENT</div>
                        <div class="stat-value">1</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">OVERDUE</div>
                        <div class="stat-value">2</div>
                    </div>
                </div>

                <div class="tabs" style="margin: 18px 0 20px;">
                    <div class="tab active">All <span class="chip">4</span></div>
                    <div class="tab">Draft <span class="chip">1</span></div>
                    <div class="tab">Sent to Supplier <span class="chip">1</span></div>
                    <div class="tab">Fully Received <span class="chip">1</span></div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>PO ID</th>
                                <th>Supplier</th>
                                <th>Expected Delivery</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PO-2026-004</td>
                                <td>OfficeMax PH</td>
                                <td>Jul 1, 2026</td>
                                <td><span class="badge badge-overdue">Draft / Overdue</span></td>
                            </tr>
                            <tr>
                                <td>PO-2026-002</td>
                                <td>TechVend Solutions</td>
                                <td>Jul 8, 2026</td>
                                <td><span class="badge badge-sent">Sent to Supplier</span></td>
                            </tr>
                            <tr>
                                <td>PO-2026-003</td>
                                <td>Green Harvest Co.</td>
                                <td>Jun 23, 2026</td>
                                <td><span class="badge badge-received">Fully Received</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="drawer">
            <div class="drawer-header">
                <div>
                    <h2>Create Purchase Order</h2>
                    <p>Use one consistent card and form system for the PO creation drawer.</p>
                </div>
                <a class="action-link" href="{{ route('procurement.purchase') }}">Back to Purchase</a>
            </div>

            <div class="drawer-body">
                <div class="drawer-card">
                    <div class="drawer-title">Purchase Summary</div>
                    <div class="summary-row"><span>Subtotal</span><strong>₱0.00</strong></div>
                    <div class="summary-row"><span>VAT (12%)</span><strong>₱0.00</strong></div>
                    <div class="summary-row summary-total"><span>Total</span><strong>₱0.00</strong></div>
                </div>

                <div class="drawer-card">
                    <div class="drawer-title">Supplier Information</div>
                    <div class="form-group">
                        <label>Supplier *</label>
                        <select>
                            <option>Select Supplier</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Expected Delivery</label>
                        <input type="date">
                    </div>
                    <div class="form-group">
                        <label>Payment Terms</label>
                        <select>
                            <option>Net 30</option>
                            <option>Net 15</option>
                            <option>COD</option>
                        </select>
                    </div>
                </div>

                <div class="drawer-card">
                    <div class="drawer-title">Line Items</div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input placeholder="AGR-SEED-001">
                    </div>
                    <div class="form-group">
                        <label>Item Name</label>
                        <input placeholder="Hybrid Rice Seeds">
                    </div>
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label>UOM</label>
                            <select><option>Unit</option></select>
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" value="1">
                        </div>
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input placeholder="₱0.00">
                        </div>
                    </div>
                </div>

                <div class="drawer-card">
                    <div class="drawer-title">Notes / Instructions</div>
                    <div class="form-group" style="margin-bottom:0;">
                        <textarea rows="4" placeholder="Delivery instructions or warehouse directions..."></textarea>
                    </div>
                </div>
            </div>

            <div class="drawer-footer">
                <a class="btn btn-ghost" href="{{ route('procurement.purchase') }}">Cancel</a>
                <a class="btn btn-primary" href="{{ route('procurement.notifications') }}">Review Alerts</a>
            </div>
        </section>
    </div>
@endsection
