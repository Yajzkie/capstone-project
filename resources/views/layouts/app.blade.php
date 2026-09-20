<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/')}}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>COTS Tracker</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Leaflet Awesome Markers -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.js"></script>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.css" />
 


    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js')}}"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            right: 0%;
            margin-right: 20px;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        #map {
            height: 100%;
            position: relative;
            margin: 10% auto 0 auto;
            width: 90%;
            height: 10%;
            margin-left: 50px;
        }

        .layout-page {
            margin-top: 0;
        }

        .user-role {
            font-weight: 600;
            color: #333;
        }

        /* ---------- Sidebar redesign ---------- */
        #layout-menu.layout-menu {
            background: linear-gradient(180deg, #0c315a 0%, #06203c 100%);
            border-right: none;
        }
        #layout-menu .app-brand {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        #layout-menu .app-brand-link { color: #fff !important; }
        #layout-menu .app-brand .menu-text { color: #fff; }
        #layout-menu .brand-logo-chip {
            background: #fff;
            border-radius: 12px;
            padding: 4px;
            display: inline-flex;
        }
        #layout-menu .sidebar-toggle {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        #layout-menu .sidebar-toggle:hover { background: rgba(255, 255, 255, 0.25); }
        #layout-menu .menu-inner { padding: 14px; }
        #layout-menu .menu-item .menu-link {
            color: rgba(255, 255, 255, 0.78);
            border-radius: 12px;
            padding: 11px 14px;
            margin-bottom: 4px;
            transition: background 0.2s ease, color 0.2s ease;
        }
        #layout-menu .menu-item .menu-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff !important;
        }
        #layout-menu .menu-item.active .menu-link {
            background: linear-gradient(135deg, #0ea5e9, #0056b3) !important;
            color: #fff !important;
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
        }
        #layout-menu .menu-icon { color: inherit; }
        #layout-menu .menu-section-label {
            color: rgba(255, 255, 255, 0.45);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 16px 14px 6px;
        }

        /* ---------- Sidebar collapsed state ---------- */
        body.sidebar-collapsed #layout-menu.layout-menu { width: 84px; }
        body.sidebar-collapsed #layout-menu .app-brand { justify-content: center; padding-left: 0; padding-right: 0; }
        body.sidebar-collapsed #layout-menu .app-brand-link,
        body.sidebar-collapsed #layout-menu .menu-section-label,
        body.sidebar-collapsed #layout-menu .menu-text { display: none; }
        body.sidebar-collapsed #layout-menu .menu-inner { padding: 14px 8px; }
        body.sidebar-collapsed #layout-menu .menu-inner > .menu-item { width: 100%; }
        body.sidebar-collapsed #layout-menu .menu-item .menu-link { justify-content: center; padding: 11px 0; }
        body.sidebar-collapsed #layout-menu .menu-item .menu-link > div { display: none; }
        body.sidebar-collapsed .layout-menu-fixed .layout-page { padding-left: 84px; }
        #layout-menu, .layout-page { transition: width 0.25s ease, padding-left 0.25s ease; }

        .navbar-nav-right {
            align-items: center;
            flex-basis: 100%;
        }

        .navbar-nav-right .nav-item {
            margin-left: 15px;
        }

        .navbar-nav {
            flex-wrap: wrap; 
        }

        .navbar {
            padding: 1rem 1.5rem;
        }

        .navbar-toggler {
            border-color: transparent;
        }
        .page-header {
        background-color: #fff;
        padding: 10px 0;
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
        font-weight: 700;
    }

    .page-header .description {
        margin: 5px 0 0 0;
        font-size: 1rem;
        color: #666;
    }
    </style>
</head>
<body>
<!-- Page Content -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @if(auth()->user()->role->role_name == 'admin')
            @include('admin.menu')
        @else
            @include('user.menu')
        @endif

        <div class="layout-page">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<!-- Sidebar toggle -->
    <script>
        document.querySelectorAll('.sidebar-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (window.innerWidth < 1200 && window.Helpers) {
                    window.Helpers.toggleCollapsed();
                } else {
                    document.body.classList.toggle('sidebar-collapsed');
                }
            });
        });
    </script>
</body>
</html>
