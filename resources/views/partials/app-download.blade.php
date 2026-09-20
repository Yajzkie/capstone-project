<style>
    .appstore-hero {
        background: linear-gradient(135deg, #001e3c 0%, #00447a 55%, #0a5bac 100%);
        border-radius: 22px;
        overflow: hidden;
        padding: 44px 40px;
        color: #fff;
    }
    .appstore-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50rem;
        padding: 4px 12px;
        font-size: 0.75rem;
    }
    .btn-store {
        border: none;
        border-radius: 12px;
        padding: 13px 26px;
        font-weight: 700;
        background: linear-gradient(135deg, #0ea5e9, #0056b3);
        color: #fff;
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
    }
    .btn-store:hover { filter: brightness(1.1); color: #fff; }
    .phone-mockup {
        width: 190px;
        height: 390px;
        margin: 0 auto;
        background: #0b2e56;
        border-radius: 36px;
        padding: 12px;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.45);
        position: relative;
    }
    .phone-mockup::before {
        content: '';
        position: absolute;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        width: 70px;
        height: 16px;
        background: #0b2e56;
        border-radius: 0 0 10px 10px;
        z-index: 2;
    }
    .phone-screen {
        width: 100%;
        height: 100%;
        border-radius: 26px;
        overflow: hidden;
        background: #06203c;
    }
    .phone-screen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .feature-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .feature-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(0, 40, 80, 0.14); }
    .feature-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .shot-frame {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 40, 80, 0.12);
    }
    .shot-frame img { width: 100%; height: 200px; object-fit: cover; }
</style>

<div class="container-fluid mt-4">

    <!-- Hero -->
    <section class="appstore-hero mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-logo-chip" style="background: #fff; border-radius: 12px; padding: 4px; display: inline-flex;">
                        <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker logo" style="height: 40px; width: auto;">
                    </span>
                    <span class="fw-bolder fs-5">COTS Tracker</span>
                </div>
                <h1 style="font-weight: 800; font-size: clamp(1.8rem, 4vw, 2.8rem);">Take COTS reporting with you</h1>
                <p class="text-white-50 mb-4">
                    Spot a Crown-of-Thorns Starfish outbreak? Log it from your phone —
                    GPS-tagged photos feed straight into the live density map that keeps
                    Southern Leyte's reefs safe.
                </p>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="appstore-badge"><i class="bx bx-current-location"></i> GPS-based</span>
                    <span class="appstore-badge"><i class="bx bx-map-alt"></i> Live map</span>
                    <span class="appstore-badge"><i class="bx bx-shield-quarter"></i> Community driven</span>
                    <span class="appstore-badge"><i class="bx bx-check-circle"></i> Free</span>
                </div>
                <a href="https://github.com/Yajzkie/Android-Cots-Tracker-app.git" target="_blank" class="btn btn-store">
                    <i class="bx bxs-download me-2"></i>Download for Android
                </a>
            </div>
            <div class="col-lg-5">
                <div class="phone-mockup">
                    <div class="phone-screen">
                        <img src="{{ asset('images/maps.png') }}" alt="COTS Tracker map view">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card feature-card">
                <div class="card-body">
                    <span class="feature-icon mb-3" style="background: #dbeafe; color: #1d4ed8;"><i class="bx bx-current-location"></i></span>
                    <h6 style="font-weight: 700;">GPS Sighting Reports</h6>
                    <p class="mb-0 text-muted small">Place a pin, snap photos, and log the COTS count — location tagged automatically.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card feature-card">
                <div class="card-body">
                    <span class="feature-icon mb-3" style="background: #e0f7f5; color: #0d9488;"><i class="bx bx-map-alt"></i></span>
                    <h6 style="font-weight: 700;">Live Density Map</h6>
                    <p class="mb-0 text-muted small">Watch sightings appear as a density map that highlights outbreak hotspots.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card feature-card">
                <div class="card-body">
                    <span class="feature-icon mb-3" style="background: #fff7e6; color: #ea8a00;"><i class="bx bxs-group"></i></span>
                    <h6 style="font-weight: 700;">Community Powered</h6>
                    <p class="mb-0 text-muted small">Researchers and local teams act on the reports you submit in real time.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card feature-card">
                <div class="card-body">
                    <span class="feature-icon mb-3" style="background: #f3e8ff; color: #9333ea;"><i class="bx bx-shield-quarter"></i></span>
                    <h6 style="font-weight: 700;">Data Privacy</h6>
                    <p class="mb-0 text-muted small">Your details stay confidential and are only used for research and monitoring.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- In the app -->
    <div class="card mb-4" style="border: none; border-radius: 18px; box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);">
        <div class="card-body">
            <h5 class="mb-1" style="font-weight: 700; color: #003049;">Inside the app</h5>
            <p class="text-muted mb-4">Sightings, photos, and the ecosystem they protect.</p>
            <div class="row g-3">
                <div class="col-6 col-lg-3"><div class="shot-frame"><img src="{{ asset('images/img1.jpg') }}" alt="Reef photo 1"></div></div>
                <div class="col-6 col-lg-3"><div class="shot-frame"><img src="{{ asset('images/img2.jpg') }}" alt="Reef photo 2"></div></div>
                <div class="col-6 col-lg-3"><div class="shot-frame"><img src="{{ asset('images/cots1.jpg') }}" alt="COTS sighting"></div></div>
                <div class="col-6 col-lg-3"><div class="shot-frame"><img src="{{ asset('images/cots2.jpg') }}" alt="COTS sighting"></div></div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <section class="appstore-hero mb-4" style="background: linear-gradient(135deg, #00447a, #0a5bac);">
        <div class="text-center py-3">
            <h3 class="mb-2" style="font-weight: 800;">Ready to protect the reef?</h3>
            <p class="text-white-50 mb-4">Grab the app and submit your first sighting today.</p>
            <a href="https://github.com/Yajzkie/Android-Cots-Tracker-app.git" target="_blank" class="btn btn-store">
                <i class="bx bxs-download me-2"></i>Download for Android
            </a>
        </div>
    </section>

</div>