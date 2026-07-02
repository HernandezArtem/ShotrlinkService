<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <x-favicon />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shortlink-brand.css') }}">
    <style>
        :root {
            --bg: #090b10;
            --surface: #12151c;
            --surface-2: #1a1f2b;
            --border: #2a3142;
            --text: #eef1f6;
            --muted: #8b93a7;
            --accent: #2ee6c5;
            --accent-dim: rgba(46, 230, 197, 0.12);
            --accent-glow: rgba(46, 230, 197, 0.35);
            --warm: #ff8f6b;
            --warm-dim: rgba(255, 143, 107, 0.15);
            --danger: #ff6b7a;
            --danger-bg: rgba(255, 107, 122, 0.1);
            --success-bg: rgba(46, 230, 197, 0.08);
            --radius: 14px;
            --radius-sm: 10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(46, 230, 197, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(46, 230, 197, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black, transparent);
            pointer-events: none;
            z-index: 0;
        }

        .bg-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            top: -200px;
            right: -150px;
            pointer-events: none;
            z-index: 0;
            filter: blur(40px);
        }

        .bg-glow-2 {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 143, 107, 0.2) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
            z-index: 0;
            filter: blur(60px);
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Header */
        .header {
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            background: rgba(9, 11, 16, 0.8);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .nav a {
            display: inline-flex;
            align-items: center;
            line-height: 1;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .nav a:hover {
            color: var(--text);
            background: var(--surface-2);
            border-color: var(--border);
        }

        .nav a.nav-cta {
            background: var(--accent);
            color: #090b10;
            font-weight: 600;
        }

        .nav a.nav-cta:hover {
            background: #5aedcf;
            box-shadow: 0 0 24px var(--accent-glow);
        }

        .nav-logout-form {
            display: contents;
            margin: 0;
        }

        .nav-logout {
            display: inline-flex;
            align-items: center;
            line-height: 1;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            font-family: inherit;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            transition: all 0.2s;
            margin: 0;
            vertical-align: middle;
        }

        .nav-logout:hover {
            color: var(--danger);
            background: var(--danger-bg);
            border-color: rgba(255, 107, 122, 0.3);
        }

        /* Main layout */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 0 4rem;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            width: 100%;
        }

        @media (max-width: 860px) {
            .hero-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .hero-side { order: 2; }
        }

        .hero-side h1 {
            font-size: clamp(2.2rem, 5vw, 3.2rem);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
        }

        .hero-side h1 em {
            font-style: normal;
            color: var(--accent);
        }

        .hero-side p {
            color: var(--muted);
            font-size: 1.1rem;
            max-width: 420px;
            margin-bottom: 2rem;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: var(--muted);
        }

        .feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* Card */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.4);
        }

        .card-brand {
            margin-bottom: 1.25rem;
        }

        .shortlink-inline-link {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .shortlink-inline-link:hover {
            text-decoration: underline;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        .card-sub {
            color: var(--muted);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        input[type="url"] {
            width: 100%;
            padding: 0.9rem 1rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="url"]::placeholder { color: #4a5268; }

        input[type="url"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        input.input-error {
            border-color: var(--danger);
            background: var(--danger-bg);
        }

        .error {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            width: 100%;
            margin-top: 1rem;
            background: linear-gradient(135deg, var(--warm), #e86b4a);
            color: #fff;
            box-shadow: 0 4px 20px var(--warm-dim);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(255, 143, 107, 0.35);
        }

        .btn-ghost {
            background: var(--surface-2);
            color: var(--text);
            border: 1px solid var(--border);
            flex: 1;
        }

        .btn-ghost:hover { border-color: var(--muted); }

        .btn-accent-outline {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
            flex: 1;
        }

        .btn-accent-outline:hover {
            background: var(--accent-dim);
        }

        .btn-sm {
            width: auto;
            margin-top: 0;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            background: var(--surface-2);
            color: var(--accent);
            border: 1px solid var(--border);
        }

        .btn-sm:hover { border-color: var(--accent); }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            margin-bottom: 1.25rem;
            border: 1px solid;
        }

        .alert-error {
            background: var(--danger-bg);
            border-color: rgba(255, 107, 122, 0.3);
            color: #ffb3bb;
        }

        .alert-error ul { margin: 0.5rem 0 0 1.1rem; }
        .alert-error li { margin: 0.2rem 0; }

        .alert-info {
            background: var(--accent-dim);
            border-color: rgba(46, 230, 197, 0.25);
            color: #a8f5e8;
        }

        .result {
            margin-top: 1.5rem;
            padding: 1.25rem;
            background: var(--success-bg);
            border: 1px solid rgba(46, 230, 197, 0.25);
            border-radius: var(--radius-sm);
        }

        .result-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--accent);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .short-url {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .short-url a {
            font-family: 'JetBrains Mono', monospace;
            color: var(--accent);
            font-size: 0.95rem;
            word-break: break-all;
            text-decoration: none;
        }

        .short-url a:hover { text-decoration: underline; }

        .auth-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Centered error pages */
        .center-page {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .center-card {
            text-align: center;
            max-width: 480px;
            width: 100%;
        }

        .center-card .code-badge {
            display: inline-block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 4rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 0 40px var(--accent-glow);
        }

        .center-card h1 {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .center-card p {
            color: var(--muted);
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }

        .center-card code {
            font-family: 'JetBrains Mono', monospace;
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0.15rem 0.5rem;
            border-radius: 6px;
            color: var(--warm);
            font-size: 0.9rem;
        }

        .footer {
            padding: 1.25rem 0;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--muted);
            font-size: 0.8rem;
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>
    <div class="bg-glow-2"></div>

    <div class="page">
        @hasSection('header')
            @yield('header')
        @else
            <header class="header">
                <div class="container header-inner">
                    <x-shortlink-logo href="{{ url('/') }}" theme="dark" size="md" />
                    <nav class="nav">
                        @auth
                            <a href="{{ url('/admin') }}">Кабинет</a>
                            <form method="POST" action="{{ url('/admin/logout') }}" class="nav-logout-form">
                                @csrf
                                <button type="submit" class="nav-logout">Выйти</button>
                            </form>
                        @else
                            <a href="{{ url('/admin/login') }}">Войти</a>
                            <a href="{{ url('/admin/register') }}" class="nav-cta">Регистрация</a>
                        @endauth
                    </nav>
                </div>
            </header>
        @endif

        @yield('content')

        @hasSection('footer')
            @yield('footer')
        @else
            <footer class="footer">
                <div class="container">
                    <span class="shortlink-brand-text">Short<span class="shortlink-brand-text__accent">Link</span></span>
                    &copy; {{ date('Y') }}
                </div>
            </footer>
        @endif
    </div>

    @stack('scripts')
</body>
</html>
