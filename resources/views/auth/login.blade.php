<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COTS Tracker - Login')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }

        /* ---------- Navbar ---------- */
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background: rgba(0, 18, 40, 0.35);
            backdrop-filter: blur(6px);
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .navbar-custom .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }
        .navbar-custom .btn {
            border-radius: 50rem;
            padding: 8px 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: #fff;
        }
        .navbar-custom .btn:hover {
            background: #fff;
            color: #003049;
            border-color: #fff;
        }

        /* ---------- Hero ---------- */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 110px 0 70px;
            position: relative;
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg,
                rgba(0, 30, 60, 0.88) 0%,
                rgba(0, 60, 110, 0.70) 45%,
                rgba(0, 86, 179, 0.45) 100%);
        }
        .hero .container { position: relative; z-index: 1; }

        .hero-heading {
            color: #fff;
            font-weight: 800;
            font-size: clamp(1.9rem, 4.5vw, 3.2rem);
            line-height: 1.15;
        }
        .hero-sub { color: rgba(255, 255, 255, 0.85); max-width: 480px; }
        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            border-radius: 50rem;
            padding: 6px 14px;
            font-size: 0.85rem;
        }

        /* ---------- Login Card ---------- */
        .login-card {
            background: #fff;
            border: none;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            max-width: 420px;
            margin-left: auto;
        }
        .login-card .card-title { color: #003049; font-weight: 700; }
        .login-card .form-control {
            border-radius: 10px;
            padding: 12px 14px 12px 42px;
        }
        .login-card .input-group-text {
            background: #f1f5f9;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #64748b;
        }
        .login-card .btn-login {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #0ea5e9, #0056b3);
        }
        .login-card .btn-login:hover { filter: brightness(1.1); }
        .login-note { font-size: 0.85rem; color: #64748b; text-align: center; }

        /* ---------- About Section ---------- */
        .about {
            background: #f6f9fc;
            padding: 90px 0 60px;
            scroll-margin-top: 60px;
        }
        .about .section-kicker {
            color: #0ea5e9;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .about .section-title { color: #003049; font-weight: 800; }
        .about .lead-text { color: #334155; line-height: 1.9; }
        .about .card-img {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 40, 80, 0.12);
        }
        .contact-bar {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);
            padding: 22px 26px;
        }

        .about #map {
            height: 340px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 40, 80, 0.12);
            z-index: 0;
        }
    </style>
</head>
<body>

<!-- Navbar with About button (top right) -->
<nav class="navbar-custom">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="brand" href="{{ route('login.form') }}">
            <span class="brand-badge"><i class="fas fa-fish"></i></span>
            COTS Tracker
        </a>
        <a href="#about" class="btn btn-outline-light btn-sm">
            <i class="fas fa-info-circle me-1"></i> About
        </a>
    </div>
</nav>

<!-- Hero: welcome left, login form right -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="hero-chip"><i class="fas fa-satellite-dish"></i> GPS-Tracked Sightings</span>
                    <span class="hero-chip"><i class="fas fa-map-marked-alt"></i> Density Maps</span>
                    <span class="hero-chip"><i class="fas fa-users"></i> Community Reports</span>
                </div>
                <h1 class="hero-heading mb-3">Protecting Southern Leyte's Coral Reefs</h1>
                <p class="hero-sub mb-0">
                    Track, report, and map Crown-of-Thorns Starfish outbreaks with the
                    community. Every sighting you log helps conservation teams act fast.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="card login-card">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="card-title text-center mb-1"><i class="fas fa-user-lock me-2"></i>Welcome back</h4>
                        <p class="text-center text-muted mb-4">Sign in to start the adventure</p>

                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}" placeholder="Enter your email" autocomplete="email" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Enter your password" autocomplete="current-password" required>
                                    <span class="input-group-text" id="togglePass" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-login" type="submit">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                            <p class="login-note mt-3 mb-0">Protected for researchers &amp; monitoring teams.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About / Learn more section -->
<section class="about" id="about">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-kicker">Learn more</span>
            <h2 class="section-title mt-2 mb-3">About COTS Tracker</h2>
            <p class="text-muted mx-auto" style="max-width: 640px;">
                A community-driven tool to document Crown-of-Thorns Starfish outbreaks before they devastate the reef.
            </p>
        </div>

        <!-- Species images -->
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-4">
                <div class="card-img"><img src="{{ asset('images/img1.jpg') }}" class="img-fluid w-100" alt="Species 1"></div>
            </div>
            <div class="col-md-4">
                <div class="card-img"><img src="{{ asset('images/img2.jpg') }}" class="img-fluid w-100" alt="Species 2"></div>
            </div>
            <div class="col-md-4">
                <div class="card-img"><img src="{{ asset('images/img3.jpg') }}" class="img-fluid w-100" alt="Species 3"></div>
            </div>
        </div>

        <!-- Map + description -->
        <div class="row g-5 align-items-center mb-5">
            <div class="col-lg-4 text-center">
                <div id="map"></div>
            </div>
            <div class="col-lg-8">
                <p class="lead-text">
                    The Southern Leyte province in the Philippines is renowned for its abundant marine resources, with its coastal waters hosting vibrant coral reefs and a rich diversity of fish species. These ecosystems not only provide essential services such as fisheries and coastal protection but also contribute to the cultural and economic well-being of the local communities. However, these ecosystems are under significant threat from recurring outbreaks of Crown-of-Thorns Seastar (COTS).
                </p>
                <p class="lead-text">
                    COTS, in large numbers, are voracious coral predators that can devastate coral reef ecosystems if left unchecked. The resulting loss of coral cover diminishes biodiversity and could disrupt the balance of marine life and compromise the resilience of these ecosystems to other stressors, such as climate change and pollution. This could significantly affect not only the health of marine habitats but also the livelihoods of communities that depend on this resource for food and tourism opportunities.
                </p>
                <p class="lead-text mb-0">
                    To address this critical issue, the COTS Tracker Mobile Application offers a cutting-edge solution. By leveraging geospatial mapping and GPS technology, the app enables users to document and geo-reference specific COTS sightings. These user-submitted reports are aggregated into visual density maps, allowing conservation practitioners and local authorities to identify areas that require urgent actions or interventions.
                </p>
            </div>
        </div>

        <!-- Contact bar -->
        <div class="contact-bar">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center" style="gap: 20px;">
                    <img src="{{ asset('images/logo1.png') }}" alt="Partner Logo 1" class="img-fluid" style="max-width: 70px;">
                    <img src="{{ asset('images/logo3.png') }}" alt="Partner Logo 2" class="img-fluid" style="max-width: 70px;">
                </div>
                <div class="text-start">
                    <p class="mb-1 fw-semibold text-muted"><small>Contact Details:</small></p>
                    <a href="mailto:ries_bt@southernleytestateu.edu.ph" class="text-decoration-none text-primary">
                        <i class="fas fa-envelope me-1"></i>ries_bt@southernleytestateu.edu.ph
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([10.306812602471465, 125.00810623168947], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var group = L.featureGroup().addTo(map);

    @foreach ($locations as $location)
        L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
            .addTo(group)
            .bindTooltip('{{ addslashes($location->name ?: $location->barangay) }}');
    @endforeach

    if (group.getLayers().length) {
        map.fitBounds(group.getBounds().pad(0.2));
    }
</script>
<script>
    // Show/hide password
    document.getElementById('togglePass').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
    });
</script>
</body>
</html>