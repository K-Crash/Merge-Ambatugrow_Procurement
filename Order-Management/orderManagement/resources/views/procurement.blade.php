@extends('layouts.procurement', [
    'pageTitle' => 'Procurement Landing',
    'workspaceTitle' => 'Procurement Landing',
    'workspaceSubtitle' => 'Purchase on the left, alerts on the right, and Create PO in a modal.',
])

@section('content')
    <style>
        .dashboard-layout {
            display: grid;
            grid-template-columns: minmax(0, 4fr) minmax(300px, 1fr);
            gap: 24px;
            align-items: start;
        }

        .page-section {
            background: #fff;
            border: 1px solid #dfe5dc;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .page-section-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 22px 24px;
            border-bottom: 1px solid #e8ece7;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #165c32;
            margin-bottom: 8px;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 3px;
            border-radius: 999px;
            background: #1e7d43;
        }

        .page-section-header h2 {
            margin: 0 0 4px;
            font-size: 24px;
            color: #14213d;
        }

        .page-section-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .section-body {
            padding: 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card {
            background: #f8faf8;
            border: 1px solid #e3e8e1;
            border-radius: 14px;
            padding: 16px;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            letter-spacing: .04em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #14213d;
        }

        .tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .tab {
            border: 1px solid #e3e8e1;
            background: #f6f7f8;
            color: #4b5563;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .tab.active {
            background: #eef7f0;
            color: #1e7d43;
            border-color: #d5e9d9;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            padding: 0 6px;
            margin-left: 6px;
            border-radius: 999px;
            background: rgba(255,255,255,.75);
            font-size: 11px;
        }

        .table-wrap {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-wrap thead th {
            text-align: left;
            padding: 14px 16px;
            color: #6b7280;
            font-size: 12px;
            background: #f8faf8;
            border-bottom: 1px solid #e8ece7;
            white-space: nowrap;
        }

        .table-wrap tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #eef1ed;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-wrap tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-sent { background: #dbe6fd; color: #2354c9; }
        .badge-received { background: #d9f2e2; color: #1e7d43; }
        .badge-overdue { background: #dc2626; color: #fff; }
        .badge-partial { background: #fdf1c7; color: #92680b; }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn,
        .action-link,
        .chip-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid #d8dfd4;
            background: #fff;
            color: #165c32;
            font-weight: 700;
            text-decoration: none;
            padding: 10px 14px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-primary {
            background: #1e7d43;
            color: #fff;
            border-color: #1e7d43;
        }

        .btn-soft {
            background: #f4f5f7;
            color: #334155;
            border-color: #e2e8f0;
        }

        .btn-ghost {
            background: #eef7f0;
            color: #165c32;
            border-color: #d5e9d9;
        }

        .alerts-card {
            display: grid;
            gap: 16px;
        }

        .mini-card {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            padding: 18px;
            background: #fff;
        }

        .mini-card:target {
            outline: 2px solid #1e7d43;
            outline-offset: 2px;
        }

        .mini-title {
            font-size: 14px;
            font-weight: 800;
            color: #2f5d34;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .muted {
            color: #6b7280;
        }

        .log-list {
            display: grid;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .log-item {
            padding: 12px 14px;
            border: 1px solid #e4e8e2;
            border-radius: 12px;
            background: #fdfefe;
        }

        .log-item strong {
            display: block;
            margin-bottom: 4px;
            color: #14213d;
        }

        .overlay-card {
            width: min(980px, calc(100vw - 48px));
            max-height: calc(100vh - 48px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 50;
        }

        .modal-backdrop:target {
            display: flex;
        }

        .modal {
            width: min(980px, calc(100vw - 48px));
            max-height: calc(100vh - 48px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .modal .drawer-header {
            flex-shrink: 0;
        }

        .modal .drawer-body {
            flex: 1;
            overflow: auto;
            min-height: 0;
        }

        .modal .drawer-footer {
            flex-shrink: 0;
        }

        @media (max-width: 1180px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .section-body,
            .page-section-header {
                padding-left: 18px;
                padding-right: 18px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-layout" id="dashboard-root">
        <section id="purchase" class="page-section">
            <div class="page-section-header">
                <div>
                    <div class="section-label">Procurement Overview</div>
                    <h2>Purchase activity and order status</h2>
                    <p>Current purchase orders with uniform spacing and alignment.</p>
                </div>
                <div class="header-actions">
                    <a class="btn btn-primary" href="#createpo-modal">CREATE PO</a>
                </div>
            </div>

            <div class="section-body">
                <div class="stats-grid">
                    <div class="stat-card"><div class="stat-label">TOTAL POS</div><div class="stat-value">4</div></div>
                    <div class="stat-card"><div class="stat-label">PENDING / DRAFT</div><div class="stat-value">1</div></div>
                    <div class="stat-card"><div class="stat-label">ACTIVE / SENT</div><div class="stat-value">1</div></div>
                    <div class="stat-card"><div class="stat-label">OVERDUE</div><div class="stat-value">2</div></div>
                </div>

                <div class="tabs">
                    <button type="button" class="tab active">All <span class="chip">4</span></button>
                    <button type="button" class="tab">Draft <span class="chip">1</span></button>
                    <button type="button" class="tab">Sent to Supplier <span class="chip">1</span></button>
                    <button type="button" class="tab">Fully Received <span class="chip">1</span></button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>PO ID</th>
                                <th>Supplier</th>
                                <th>Date Issued</th>
                                <th>Expected Delivery</th>
                                <th>Total (₱)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody data-po-table>
                            <tr>
                                <td>PO-2026-004</td>
                                <td>OfficeMax PH</td>
                                <td>Jun 28, 2026</td>
                                <td>Jul 1, 2026</td>
                                <td>15,680.00</td>
                                <td><span class="badge badge-overdue">Draft / Overdue</span></td>
                                <td><div class="action-row"><a class="chip-link" href="#createpo-modal">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td>PO-2026-002</td>
                                <td>TechVend Solutions</td>
                                <td>Jun 24, 2026</td>
                                <td>Jul 8, 2026</td>
                                <td>67,200.00</td>
                                <td><span class="badge badge-sent">Sent to Supplier</span></td>
                                <td><div class="action-row"><a class="chip-link" href="#delivery-alerts">Review</a></div></td>
                            </tr>
                            <tr>
                                <td>PO-2026-003</td>
                                <td>Green Harvest Co.</td>
                                <td>Jun 18, 2026</td>
                                <td>Jun 23, 2026</td>
                                <td>22,400.00</td>
                                <td><span class="badge badge-received">Fully Received</span></td>
                                <td><div class="action-row"><a class="chip-link" href="#procurement-logs">Logs</a></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <aside id="sidenotif" class="page-section">
            <div class="page-section-header">
                <div>
                    <div class="section-label">Workflow Alerts</div>
                    <h2>Notifications and pipeline health</h2>
                    <p>Compact alerts panel aligned to the same visual system.</p>
                </div>
                <a class="action-link" href="#purchase">Purchase</a>
            </div>

            <div class="section-body alerts-card">
                <div class="mini-card">
                    <div class="mini-title">Approvals Inbox</div>
                    <div class="badge" style="background:#fef3d6; color:#b8860b;">0 Awaiting</div>
                    <p class="muted" style="margin: 14px 0 0;">Approval queue is empty.</p>
                </div>

                <div class="mini-card">
                    <div class="mini-title">PO Pipeline</div>
                    <div class="stats-grid" style="grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-bottom: 14px;">
                        <div class="stat-card"><div class="stat-label">Drafts</div><div class="stat-value">1</div></div>
                        <div class="stat-card"><div class="stat-label">In Flight</div><div class="stat-value">2</div></div>
                    </div>
                    <div class="stat-card"><div class="stat-label">Total Procurement Value</div><div class="stat-value">₱227,920</div></div>
                </div>

                <div class="mini-card" id="notifications">
                    <div class="mini-title">Notifications</div>

                    <div class="mini-card" id="delivery-alerts" style="margin-bottom:14px; padding:16px;">
                        <div class="mini-title" style="margin-bottom:10px;">Delivery Alerts</div>
                        <div class="badge badge-overdue" style="display:inline-flex; margin-bottom:10px;">PO-2026-001 Overdue</div>
                        <p style="margin:0; font-weight:700;">AgriSource PH Inc.</p>
                        <p class="muted" style="margin:6px 0 0;">Immediate follow-up required.</p>
                    </div>

                    <div class="mini-card" id="procurement-logs" style="padding:16px;">
                        <div class="mini-title" style="margin-bottom:10px;">Invoice Matching</div>
                        <div class="badge badge-partial" style="display:inline-flex; margin-bottom:10px;">Discrepancy</div>
                        <p style="margin:0; font-weight:700;">INV-SUP-2026-003</p>
                        <p class="muted" style="margin:6px 0 0;">TechVend Solutions - ₱67,200</p>
                    </div>
                </div>

            </div>
        </aside>
    </div>

    <div class="modal-backdrop" id="createpo-modal" aria-hidden="true">
        <div class="modal overlay-card">
            <div class="drawer-header">
                <div>
                    <div class="section-label">PO Entry</div>
                    <h2>New purchase order</h2>
                    <p>Popup form layered over the procurement dashboard.</p>
                </div>
                <a class="btn btn-soft" href="#purchase">Close</a>
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
                        <select><option>Select Supplier</option></select>
                    </div>
                    <div class="form-group">
                        <label>Expected Delivery</label>
                        <input type="date">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
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
                    <div class="stats-grid" style="grid-template-columns: 1fr .8fr 1fr; gap: 14px;">
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
                <a class="btn btn-ghost" href="#purchase">Cancel</a>
                <a class="btn btn-primary" href="#purchase">Save Draft</a>
            </div>
        </div>
    </div>

@endsection
