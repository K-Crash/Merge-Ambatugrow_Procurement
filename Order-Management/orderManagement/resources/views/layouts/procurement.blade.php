<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Procurement Workspace' }}</title>
    <style>
        :root {
            --bg: #eef2f3;
            --surface: #ffffff;
            --surface-soft: #f8faf8;
            --border: #dfe5dc;
            --border-soft: #e8ece7;
            --text: #1f2937;
            --muted: #6b7280;
            --brand: #1e7d43;
            --brand-dark: #165c32;
            --brand-soft: #eef7f0;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top left, #f7faf8 0%, var(--bg) 45%, #e8eeea 100%);
            color: var(--text);
        }

        a { color: inherit; }

        .page-shell { min-height: 100vh; padding: 24px; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .brand h1 {
            margin: 0 0 6px;
            font-size: 28px;
            line-height: 1.1;
            color: #14213d;
        }

        .brand p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .action-link,
        .btn,
        .chip-link {
            text-decoration: none;
            border-radius: 999px;
            font-weight: 700;
            transition: transform 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .action-link:hover,
        .btn:hover,
        .chip-link:hover { transform: translateY(-1px); }

        .content-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 520px;
            gap: 24px;
            align-items: start;
        }

        .dashboard-layout {
            display: grid;
            grid-template-columns: minmax(0, 4fr) minmax(320px, 1fr);
            gap: 24px;
            align-items: start;
        }

        .landing-grid {
            display: grid;
            gap: 24px;
        }

        .panel,
        .drawer,
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-header,
        .drawer-header {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .panel-header h2,
        .drawer-header h2 {
            margin: 0 0 4px;
            color: #14213d;
            font-size: 24px;
        }

        .panel-header p,
        .drawer-header p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .card-section { padding: 24px; }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .stat-card {
            background: var(--surface-soft);
            border: 1px solid #e3e8e1;
            border-radius: 14px;
            padding: 16px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .04em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #14213d;
        }

        .tabs { display: flex; gap: 8px; flex-wrap: wrap; }

        .tab {
            background: #f6f7f8;
            border: 1px solid #e3e8e1;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 13px;
            color: #4b5563;
            font-weight: 600;
        }

        .tab.active {
            background: var(--brand-soft);
            border-color: #d5e9d9;
            color: var(--brand);
        }

        .badge,
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-sent { background: #dbe6fd; color: #2354c9; }
        .badge-received { background: #d9f2e2; color: var(--brand); }
        .badge-overdue { background: #dc2626; color: #fff; }
        .badge-partial { background: #fdf1c7; color: #92680b; }
        .badge-draft { background: #eef0f2; color: #4b5563; }

        .table-wrap {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            overflow: hidden;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-wrap thead th {
            background: #f8faf8;
            padding: 14px 16px;
            text-align: left;
            color: var(--muted);
            font-size: 12px;
            border-bottom: 1px solid var(--border-soft);
        }

        .table-wrap tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #eef1ed;
            vertical-align: middle;
        }

        .table-wrap tbody tr:last-child td { border-bottom: none; }

        .action-row { display: flex; gap: 8px; flex-wrap: wrap; }

        .btn,
        .action-link,
        .chip-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d8dfd4;
            background: #fff;
            color: var(--brand-dark);
            padding: 10px 14px;
            font-size: 13px;
        }

        .btn-primary { background: var(--brand); color: #fff; border-color: var(--brand); }
        .btn-ghost { background: var(--brand-soft); color: var(--brand-dark); border-color: #d5e9d9; }
        .btn-soft { background: #f4f5f7; color: #334155; border-color: #e2e8f0; }

        .drawer { display: flex; flex-direction: column; }

        .drawer-body {
            padding: 24px;
            display: grid;
            gap: 18px;
        }

        .drawer-card {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            padding: 18px;
            background: #fff;
        }

        .drawer-title {
            font-size: 14px;
            font-weight: 800;
            color: #2f5d34;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .form-group { margin-bottom: 14px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #4b5563;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid #d6ddd3;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 14px;
            outline: none;
            background: #fff;
            font-family: inherit;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr .8fr 1fr;
            gap: 14px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            color: #555;
        }

        .summary-total {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 12px;
            font-weight: 700;
            font-size: 18px;
            color: var(--brand);
        }

        .drawer-footer {
            border-top: 1px solid #e4e8e2;
            padding: 20px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #fff;
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

        .modal-backdrop.is-open {
            display: flex;
        }

        .modal {
            width: min(100%, 980px);
            max-height: calc(100vh - 48px);
            overflow: auto;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .modal .drawer-body {
            max-height: calc(100vh - 220px);
            overflow: auto;
        }

        body.modal-open .page-shell {
            pointer-events: none;
            user-select: none;
        }

        body.modal-open {
            overflow: hidden;
        }

        .section-anchor {
            scroll-margin-top: 24px;
        }

        .modal-close {
            cursor: pointer;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--brand-dark);
            margin-bottom: 10px;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 3px;
            border-radius: 999px;
            background: var(--brand);
        }

        .muted { color: var(--muted); }

        @media (max-width: 1180px) {
            .content-layout { grid-template-columns: 1fr; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 720px) {
            .page-shell { padding: 16px; }
            .stats { grid-template-columns: 1fr; }
            .panel-header,
            .drawer-header,
            .drawer-footer,
            .card-section,
            .drawer-body { padding-left: 18px; padding-right: 18px; }
            .form-grid-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div class="brand">
                <h1>{{ $workspaceTitle ?? 'Procurement Workspace' }}</h1>
                <p>{{ $workspaceSubtitle ?? 'A consistent frontend for purchase orders, creation, and notifications.' }}</p>
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>
