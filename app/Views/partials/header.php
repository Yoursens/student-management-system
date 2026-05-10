<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= esc($title ?? 'StudentSys') ?> — TA2 System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0d0f12;
            --bg-card: #161a1f;
            --bg-sidebar: #111418;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --accent-soft: rgba(59,130,246,.15);
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-primary: #e8eaed;
            --text-muted: #6b7280;
            --border: rgba(255,255,255,.07);
            --sidebar-w: 240px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            z-index: 100;
            padding: 0;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand h5 {
            font-weight: 600; font-size: .95rem;
            color: var(--text-primary); margin: 0;
            letter-spacing: -.01em;
        }
        .sidebar-brand small {
            font-family: 'DM Mono', monospace;
            font-size: .7rem; color: var(--accent);
        }
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section {
            font-size: .65rem; font-weight: 600; letter-spacing: .1em;
            text-transform: uppercase; color: var(--text-muted);
            padding: .75rem 1.25rem .35rem;
        }
        .sidebar-nav a {
            display: flex; align-items: center; gap: .65rem;
            padding: .55rem 1.25rem; font-size: .85rem;
            color: var(--text-muted); text-decoration: none;
            border-radius: 0; transition: all .15s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: var(--accent-soft);
            color: var(--text-primary);
            border-left-color: var(--accent);
        }
        .sidebar-nav a i { font-size: 1rem; width: 1.1rem; }
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
            font-size: .8rem; color: var(--text-muted);
        }
        .sidebar-footer strong { display: block; color: var(--text-primary); font-size: .85rem; }
        .badge-role {
            font-size: .65rem; padding: .2rem .5rem;
            border-radius: 20px; font-family: 'DM Mono', monospace;
        }

        /* ── Main content ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }
        .topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: .85rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1rem; font-weight: 600; margin: 0; }
        .content-area { padding: 1.75rem; }

        /* ── Cards ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            font-weight: 600; font-size: .9rem;
            padding: 1rem 1.25rem;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.25rem;
        }
        .stat-card .stat-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: .85rem;
        }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 600; line-height: 1; }
        .stat-card .stat-label { font-size: .78rem; color: var(--text-muted); margin-top: .3rem; }

        /* ── Tables ── */
        .table {
            color: var(--text-primary);
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--border);
        }
        .table thead th {
            font-size: .72rem; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--text-muted); border-bottom: 1px solid var(--border);
            padding: .75rem 1rem;
        }
        .table tbody td { padding: .75rem 1rem; font-size: .875rem; }
        .table-hover tbody tr:hover { background: rgba(255,255,255,.025); }

        /* ── Forms ── */
        .form-control, .form-select {
            background: #1e2229; border: 1px solid var(--border);
            color: var(--text-primary); border-radius: 7px;
            font-size: .875rem;
        }
        .form-control:focus, .form-select:focus {
            background: #1e2229; border-color: var(--accent);
            color: var(--text-primary); box-shadow: 0 0 0 3px var(--accent-soft);
        }
        .form-label { font-size: .8rem; font-weight: 500; color: var(--text-muted); margin-bottom: .4rem; }
        .input-group-text { background: #1a1e24; border-color: var(--border); color: var(--text-muted); }

        /* ── Buttons ── */
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-hover); border-color: var(--accent-hover); }
        .btn-sm { font-size: .78rem; }

        /* ── Alerts ── */
        .alert { border-radius: 8px; font-size: .875rem; }

        /* ── Badges ── */
        .badge { font-weight: 500; }

        /* ── Pagination ── */
        .page-link {
            background: var(--bg-card); border-color: var(--border);
            color: var(--text-muted); font-size: .8rem;
        }
        .page-link:hover { background: var(--accent-soft); color: var(--accent); border-color: var(--border); }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }

        /* ── Search bar ── */
        .search-wrap { position: relative; }
        .search-wrap .bi-search {
            position: absolute; left: .8rem; top: 50%;
            transform: translateY(-50%); color: var(--text-muted); font-size: .85rem;
        }
        .search-wrap input { padding-left: 2.2rem; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-mortarboard-fill me-2" style="color:var(--accent)"></i>StudentSys</h5>
        <small><?= esc(session()->get('role_name') ?? 'Guest') ?> Panel</small>
    </div>

    <nav class="sidebar-nav">
        <?php if (session()->get('role_name') === 'Admin'): ?>
        <div class="nav-section">Main</div>
        <a href="/admin/dashboard" class="<?= (uri_string() === 'admin/dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <div class="nav-section">Students</div>
        <a href="/admin/students" class="<?= str_starts_with(uri_string(), 'admin/students') ? 'active' : '' ?>">
            <i class="bi bi-person-lines-fill"></i> All Students
        </a>
        <a href="/admin/students/create">
            <i class="bi bi-person-plus"></i> Add Student
        </a>
        <div class="nav-section">Admin</div>
        <a href="/admin/users" class="<?= str_starts_with(uri_string(), 'admin/users') ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Manage Users
        </a>
        <a href="/admin/audit-logs" class="<?= str_starts_with(uri_string(), 'admin/audit') ? 'active' : '' ?>">
            <i class="bi bi-journal-text"></i> Audit Logs
        </a>
        <div class="nav-section">API</div>
        <a href="/api/students" target="_blank">
            <i class="bi bi-braces"></i> GET /api/students
        </a>
        <a href="/api/stats" target="_blank">
            <i class="bi bi-bar-chart"></i> GET /api/stats
        </a>
        <?php else: ?>
        <div class="nav-section">Main</div>
        <a href="/staff/dashboard" class="<?= (uri_string() === 'staff/dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="/staff/students" class="<?= str_starts_with(uri_string(), 'staff/students') ? 'active' : '' ?>">
            <i class="bi bi-person-lines-fill"></i> View Students
        </a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <strong><?= esc(session()->get('full_name') ?? '') ?></strong>
        <span class="badge badge-role bg-primary mt-1"><?= esc(session()->get('role_name') ?? '') ?></span>
        <a href="/logout" class="btn btn-sm btn-outline-secondary mt-2 w-100">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
    </div>
</aside>

<!-- Main wrap -->
<div class="main-wrap">
    <header class="topbar">
        <h6 class="topbar-title"><?= esc($title ?? '') ?></h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:.78rem">
                <?= date('D, d M Y') ?>
            </span>
            <a href="/api/students" target="_blank" class="btn btn-sm btn-outline-primary" style="font-size:.75rem">
                <i class="bi bi-braces me-1"></i>API
            </a>
        </div>
    </header>
    <div class="content-area">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <ul class="mb-0 ps-3">
        <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0 ps-3">
        <?php foreach ((array) $errors as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
