<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="বেচাকেনা — Your trusted e-commerce marketplace in Bangladesh">
    <title>@yield('title', 'বেচাকেনা — E-Commerce Marketplace')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── CSS Reset & Variables ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary: #0f1117;
            --bg-secondary: #1a1d27;
            --bg-card: #1e2130;
            --bg-card-hover: #252840;
            --border-color: #2a2d3e;
            --text-primary: #e8eaed;
            --text-secondary: #9aa0b4;
            --text-muted: #6b7185;
            --accent: #6c5ce7;
            --accent-hover: #7d6ff0;
            --accent-glow: rgba(108, 92, 231, 0.3);
            --success: #00b894;
            --success-bg: rgba(0, 184, 148, 0.1);
            --danger: #e74c6f;
            --danger-bg: rgba(231, 76, 111, 0.1);
            --warning: #fdcb6e;
            --warning-bg: rgba(253, 203, 110, 0.1);
            --info: #74b9ff;
            --gradient-primary: linear-gradient(135deg, #6c5ce7, #a855f7, #6c5ce7);
            --gradient-card: linear-gradient(145deg, #1e2130, #252840);
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.4);
            --font-main: 'Inter', 'Noto Sans Bengali', system-ui, sans-serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        a { color: var(--accent); text-decoration: none; transition: var(--transition); }
        a:hover { color: var(--accent-hover); }

        /* ── Navbar ── */
        .navbar {
            background: rgba(26, 29, 39, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--bg-card);
        }

        .nav-link.active {
            color: var(--accent);
            background: rgba(108, 92, 231, 0.1);
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-user-name {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .nav-badge {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            background: rgba(108, 92, 231, 0.15);
            color: var(--accent);
        }

        /* ── Main Content ── */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* ── Cards ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: var(--transition);
        }

        .card:hover {
            border-color: var(--accent);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-family: var(--font-main);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 2px 10px var(--accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 20px var(--accent-glow);
            color: white;
        }

        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #d63b5f;
            color: white;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #00a884;
            color: white;
        }

        .btn-sm {
            padding: 0.4rem 0.9rem;
            font-size: 0.8rem;
        }

        .btn-block {
            width: 100%;
        }

        /* ── Forms ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: var(--font-main);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239aa0b4' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* ── Alerts ── */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.25rem;
            font-size: 0.9rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border-color: rgba(0, 184, 148, 0.2);
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: rgba(231, 76, 111, 0.2);
        }

        .alert-warning {
            background: var(--warning-bg);
            color: var(--warning);
            border-color: rgba(253, 203, 110, 0.2);
        }

        .alert-info {
            background: rgba(116, 185, 255, 0.1);
            color: var(--info);
            border-color: rgba(116, 185, 255, 0.2);
        }

        /* ── Tables ── */
        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.8rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: var(--bg-card-hover);
        }

        /* ── Badges / Status ── */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: var(--success-bg); color: var(--success); }
        .badge-danger { background: var(--danger-bg); color: var(--danger); }
        .badge-warning { background: var(--warning-bg); color: var(--warning); }
        .badge-info { background: rgba(116, 185, 255, 0.1); color: var(--info); }
        .badge-primary { background: rgba(108, 92, 231, 0.15); color: var(--accent); }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* ── Grid ── */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        @media (max-width: 992px) {
            .grid-4, .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .grid-4, .grid-3, .grid-2 { grid-template-columns: 1fr; }
            .main-content { padding: 1rem; }
            .navbar { padding: 0 1rem; }
            .page-header { flex-direction: column; gap: 1rem; align-items: flex-start; }
        }

        /* ── Auth Form Container ── */
        .auth-container {
            max-width: 440px;
            margin: 3rem auto;
        }

        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .auth-card h2 {
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .auth-card .subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* ── Radio Group ── */
        .radio-group {
            display: flex;
            gap: 1rem;
        }

        .radio-option {
            flex: 1;
            position: relative;
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .radio-option label {
            display: block;
            padding: 0.7rem;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .radio-option input[type="radio"]:checked + label {
            border-color: var(--accent);
            background: rgba(108, 92, 231, 0.1);
            color: var(--accent);
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
            list-style: none;
        }

        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.5rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .pagination a:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .pagination .active span {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /* ── Stars (Reviews) ── */
        .stars {
            color: #fdcb6e;
            font-size: 1rem;
        }

        .stars-muted {
            color: var(--text-muted);
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
        }

        /* ── Actions row ── */
        .actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* ── Inline form (for delete buttons etc.) ── */
        .inline-form {
            display: inline;
        }

        /* ── Price ── */
        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--success);
        }

        .price-sm {
            font-size: 0.95rem;
        }

        /* ── Search / Filter Bar ── */
        .filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-bar .form-group {
            margin-bottom: 0;
            flex: 1;
            min-width: 150px;
        }

        /* ── Utility ── */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-muted { color: var(--text-muted); }
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .flex { display: flex; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">বেচাকেনা</a>
        <ul class="navbar-nav">
            <li><a href="/products" class="nav-link">Products</a></li>

            @if(session('user_id'))
                @if(session('role') === 'customer')
                    <li><a href="/cart" class="nav-link">🛒 Cart</a></li>
                    <li><a href="/orders" class="nav-link">My Orders</a></li>
                @elseif(session('role') === 'seller')
                    <li><a href="/seller/products" class="nav-link">My Products</a></li>
                    <li><a href="/seller/orders" class="nav-link">Orders</a></li>
                @elseif(session('role') === 'admin')
                    <li><a href="/admin/brands" class="nav-link">Brands</a></li>
                    <li><a href="/admin/categories" class="nav-link">Categories</a></li>
                    <li><a href="/admin/orders" class="nav-link">Orders</a></li>
                @endif

                <li class="nav-user">
                    <span class="nav-user-name">{{ session('user_name') }}</span>
                    <span class="nav-badge">{{ session('role') }}</span>
                </li>
                <li>
                    <form action="/logout" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none;border:none;cursor:pointer;">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="/login" class="nav-link">Login</a></li>
                <li><a href="/register" class="btn btn-primary btn-sm">Sign Up</a></li>
            @endif
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="list-style:none;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
