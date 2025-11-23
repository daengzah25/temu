<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Platform Temu - Temukan UMKM Terdekat">
    <title>@yield('title', 'Temu')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #F9FAFB;
            color: #1F2937;
            font-size: 16px;
            line-height: 1.5;
            padding-bottom: 70px;
        }

        /* Spacing */
        .mb { margin-bottom: 8px; }
        .mb2 { margin-bottom: 16px; }
        .mb3 { margin-bottom: 24px; }
        .mt2 { margin-top: 16px; }
        .p2 { padding: 16px; }

        /* Layout */
        .container { max-width: 480px; margin: 0 auto; padding: 16px; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap { gap: 12px; }
        .text-center { text-align: center; }

        /* Card */
        .card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Typography */
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
        h2 { font-size: 20px; font-weight: 600; margin-bottom: 8px; }
        h3 { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
        .text-sm { font-size: 14px; }
        .text-gray { color: #6B7280; }
        .text-blue { color: #3B82F6; }

        /* Button */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 16px;
            min-height: 48px;
            transition: all 0.2s;
        }
        .btn-primary { background: #3B82F6; color: white; }
        .btn-primary:active { background: #2563EB; }
        .btn-block { display: block; width: 100%; }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #E5E7EB;
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            z-index: 1000;
        }
        .bottom-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 16px;
            color: #6B7280;
            text-decoration: none;
            flex: 1;
        }
        .bottom-nav a.active { color: #3B82F6; }
        .bottom-nav a i { font-size: 24px; margin-bottom: 4px; }
        .bottom-nav a span { font-size: 12px; }

        /* Input */
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 16px;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #3B82F6;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    @yield('bottom-nav')

    @stack('scripts')
</body>
</html>
