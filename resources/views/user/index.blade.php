@extends('layouts.app')

@section('content')
<style>
    /* ---------- Sighting wizard modal theme ---------- */

    /* Overlay */
    .modal.fade .modal-dialog {
        transform: translateY(14px);
        opacity: 0;
        transition: transform 0.28s ease, opacity 0.28s ease;
    }
    .modal.fade.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }

    /* Content */
    .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(6, 32, 60, 0.28);
    }

    /* Header */
    .modal-header {
        background: linear-gradient(135deg, #0c315a 0%, #06203c 55%, #0056b3 100%);
        color: #fff;
        border-bottom: none;
        padding: 18px 24px;
        align-items: center;
    }
    .modal-title {
        font-weight: 700;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-header p {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.75);
        margin: 0;
    }
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.75;
    }
    .btn-close:hover { opacity: 1; }

    /* Body */
    .modal-body { padding: 24px; }

    /* Wizard stepper */
    .wizard-steps {
        display: flex;
        align-items: flex-start;
        margin-bottom: 22px;
        padding: 14px 10px;
        background: #f4f7fb;
        border-radius: 12px;
    }
    .wz-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        flex: 0 0 auto;
        min-width: 52px;
    }
    .wz-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        background: #dbe4ee;
        color: #5c7387;
        transition: all 0.2s ease;
    }
    .wz-step.active .wz-dot {
        background: linear-gradient(135deg, #0ea5e9, #0056b3);
        color: #fff;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.35);
    }
    .wz-step.done .wz-dot {
        background: #0ea5e9;
        color: #fff;
    }
    .wz-label {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #8fa3b5;
        white-space: nowrap;
    }
    .wz-step.active .wz-label,
    .wz-step.done .wz-label { color: #0c315a; }
    .wz-bar {
        flex: 1 1 auto;
        height: 2px;
        margin-top: 14px;
        background: #dbe4ee;
        border-radius: 2px;
    }
    .wz-bar.done { background: linear-gradient(90deg, #0ea5e9, #0056b3); }

    /* Form */
    .form-group label {
        color: #33475b;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.92rem;
    }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #dbe4ee;
        padding: 10px 14px;
        font-size: 0.95rem;
        background: #fbfdff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0ea5e9;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }

    /* COTS count grid */
    .count-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .count-grid .form-group { margin-bottom: 0; }
    .total-box {
        margin-top: 18px;
        padding: 14px 18px;
        border-radius: 12px;
        background: linear-gradient(135deg, #eef7ff, #e2eefc);
        border: 1px solid #cfe4f6;
    }
    .total-box label { color: #0c315a; }

    /* Location readout */
    .loc-readout {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f4f7fb;
        border: 1px dashed #c3d5e4;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    .loc-readout i { color: #0056b3; font-size: 1.15rem; }

    /* Photo previews */
    #photo-previews img {
        border-radius: 10px;
        border: 2px solid #e2eefc;
        object-fit: cover;
    }

    /* Footer */
    .modal-footer {
        border-top: 1px solid #eef2f7;
        padding: 16px 24px;
        gap: 10px;
    }
    .modal-footer .btn { border-radius: 9px; font-weight: 600; padding: 9px 20px; }
    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #0056b3);
        border: none;
        transition: filter 0.2s ease, transform 0.2s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0ea5e9, #0056b3);
        filter: brightness(1.1);
        transform: translateY(-1px);
    }
    .btn-secondary { background: #eef2f7; border: none; color: #33475b; }
    .btn-secondary:hover { background: #e2e8f0; color: #0c315a; }
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        transition: filter 0.2s ease, transform 0.2s ease;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #10b981, #059669);
        filter: brightness(1.1);
        transform: translateY(-1px);
    }
</style>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bx bx-check-circle fs-5 me-2"></i>
        <div>
            <strong>Sighting uploaded!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Hero header -->
<div class="card hero-card mb-4">
    <div class="card-body p-4 p-md-5 text-white">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="hero-chip2"><i class="bx bx-map-alt"></i> Live sightings map</span>
            <span class="hero-chip2"><i class="bx bx-current-location"></i> Report by placing a pin</span>
            <span class="hero-chip2"><i class="bx bx-shield-quarter"></i> Helps protect coral reefs</span>
        </div>
        <h1 class="mb-2" style="font-weight: 800;">COTS Sighting Map</h1>
        <p class="mb-0 text-white-50" style="max-width: 660px;">
            View all reported Crown-of-Thorns Starfish (COTS) sightings on the interactive map.
            Help protect our reefs by clicking the map to place a pin and reporting a new sighting in your area.
        </p>
    </div>
</div>

<style>
    .hero-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        background: linear-gradient(120deg, #001e3c 0%, #00447a 60%, #0a5bac 100%);
    }
    .hero-chip2 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #fff;
        border-radius: 50rem;
        padding: 5px 12px;
        font-size: 0.8rem;
    }
    .content-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);
    }
    #map {
        height: 520px;
        border-radius: 14px;
        z-index: 0;
    }
    @media (max-width: 767.98px) {
        #map { height: 380px; }
    }
</style>

<div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
                <div class="content-wrapper">
                    <!-- Map card with filters -->
                    <div class="card content-card mb-4">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                                <div class="flex-grow-1" style="min-width: 180px;">
                                    <label for="filterMunicipality" class="form-label small text-muted mb-1">Filter by Municipality</label>
                                    <select class="form-select" id="filterMunicipality" onchange="applyFilters()">
                                        <option value="">All municipalities</option>
                                        @foreach($locations->pluck('municipality')->filter()->unique()->sort() as $municipalityName)
                                        <option value="{{ $municipalityName }}">{{ $municipalityName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="min-width: 180px;">
                                    <label for="filterDate" class="form-label small text-muted mb-1">Filter by Date</label>
                                    <input type="date" class="form-control" id="filterDate" onchange="applyFilters()">
                                </div>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                    <i class="bx bx-reset"></i> Reset
                                </button>
                                <span id="filterCount" class="text-muted small ms-auto mb-2"></span>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>

                    <!-- My Sightings -->
                    <div class="card content-card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight: 700;">My Sighting Reports</h5>
                            <span class="badge rounded-pill text-white" style="background: #0056b3;">{{ $mySightings->count() }}</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>COTS Count</th>
                                        <th>Photo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($mySightings as $sighting)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $sighting->barangay }}
                                            @if($sighting->municipality), {{ $sighting->municipality }}@endif
                                        </td>
                                        <td>{{ $sighting->date_of_sighting }}</td>
                                        <td>{{ $sighting->time_of_sighting }}</td>
                                        <td><span class="fw-semibold">{{ $sighting->number_of_cots ?: 0 }}</span></td>
                                        <td>
                                            @php $sightingPhotos = json_decode($sighting->photo ?? '', true) ?: []; @endphp
                                            @if(!empty($sightingPhotos[0]))
                                                <img src="{{ asset('storage/' . $sightingPhotos[0]) }}" width="52" height="52" style="object-fit: cover; border-radius: 10px;">
                                            @else
                                                <span class="text-muted">&mdash;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bx bx-current-location fs-1"></i>
                                            <p class="mt-2 mb-0">You haven't reported any sightings yet.<br>
                                                Click on the map to place a pin and submit your first report!</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                 <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="consentModalLabel"><i class="bx bx-shield-quarter"></i> Data Privacy Consent</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fs-5">
                                        All of the information that the respondents will provide will be treated as confidential and will only be used for research purposes.
                                        We are committed to protecting your personal information and respecting your privacy.
                                        Any personal information provided will be treated with confidentiality.
                                    </p> 
                                    
                                    <p class="text-muted">
                                        By clicking <strong>"I Agree"</strong>, you consent to the collection and processing of your data for research and monitoring purposes, in accordance with applicable data privacy laws.
                                    </p>
                                    <div class="row g-2 my-3">
                                        <div class="col-6">
                                            <img src="{{ asset('images/img1.jpg') }}" class="img-fluid rounded" alt="Species 1">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img2.jpg') }}" class="img-fluid rounded" alt="Species 2">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img3.jpg') }}" class="img-fluid rounded" alt="Species 3">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img4.jpg') }}" class="img-fluid rounded" alt="Species 3">
                                        </div>
                                    </div>

                                    <p>
                                      The Crown-of-Thorns Starfish (COTS) or locally known as Dap-ag is a marine species known for its significant impact on coral reefs. While it is a natural part of the ecosystem, during population outbreaks, COTS can devastate coral reefs by feeding on coral polyps, leading to extensive coral degradation. This species poses a major threat to coral ecosystems, especially in tropical and subtropical regions, and is considered one of the key factors in coral reef decline. Effective management and research are essential to mitigate the damage caused by COTS outbreaks and protect vital marine biodiversity.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="agreeConsent">I Agree</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('user-save-location') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Modal 1: Sighting Details -->
    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label"><i class="bx bx-current-location"></i> Sighting Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @include('partials.wizard-steps', ['activeStep' => 1])

                    <div class="form-group">
                        <label for="name"><i class="bx bx-user"></i> Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="date_of_sighting"><i class="bx bx-calendar"></i> Date of COTS Sighting</label>
                        <input type="date" class="form-control" id="date_of_sighting" name="date_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="time_of_sighting"><i class="bx bx-time-five"></i> Time of COTS Sighting</label>
                        <input type="time" class="form-control" id="time_of_sighting" name="time_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="municipality"><i class="bx bx-map-alt"></i> Municipality</label>
                        <select class="form-select" id="municipality" name="municipality" required>
                            <option value="">Select Municipality</option>
                            <!-- Municipalities will be populated here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay"><i class="bx bx-map-pin"></i> Barangay</label>
                        <select class="form-select" id="barangay" name="barangay" required>
                            <option value="">Select Barangay</option>
                            <!-- Barangays will be populated here -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="nextBtn1"><i class="bx bx-chevron-right"></i> Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: COTS Count -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label"><i class="bx bx-analyse"></i> COTS Count</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.wizard-steps', ['activeStep' => 2])

                    <div class="count-grid">
                        <div class="form-group">
                            <label for="early_juvenile"><i class="bx bx-ruler"></i> 1-5cm</label>
                            <input type="number" class="form-control" id="early_juvenile" name="early_juvenile" min="0" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label for="juvenile"><i class="bx bx-ruler"></i> 6-15cm</label>
                            <input type="number" class="form-control" id="juvenile" name="juvenile" min="0" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label for="sub_adult"><i class="bx bx-ruler"></i> 15-25cm</label>
                            <input type="number" class="form-control" id="sub_adult" name="sub_adult" min="0" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label for="adult"><i class="bx bx-ruler"></i> 25-35cm</label>
                            <input type="number" class="form-control" id="adult" name="adult" min="0" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label for="late_adult"><i class="bx bx-ruler"></i> &gt;35cm</label>
                            <input type="number" class="form-control" id="late_adult" name="late_adult" min="0" placeholder="0">
                        </div>
                    </div>

                    <div class="total-box">
                        <div class="form-group mb-0">
                            <label for="number_of_cots"><i class="bx bx-star"></i> Total COTS</label>
                            <input type="number" class="form-control" id="number_of_cots" name="number_of_cots" min="0" placeholder="Auto-calculated" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backBtn2"><i class="bx bx-chevron-left"></i> Back</button>
                    <button type="button" class="btn btn-primary" id="nextBtn2">Next <i class="bx bx-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Activity & Observer Info -->
    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal3Label"><i class="bx bx-group"></i> Activity & Observer Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.wizard-steps', ['activeStep' => 3])

                    <div class="form-group">
                        <label for="activity_type"><i class="bx bx-category-alt"></i> Type of Activity</label>
                        <select class="form-select" id="activity_type" name="activity_type" required>
                            <option value="">Select Activity</option>
                            <option value="Fishing">Fishing</option>
                            <option value="Recreational diving">Recreational Diving</option>
                            <option value="Research">Research</option>
                            <option value="Cots collection">COTS Collection</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_activity" name="custom_activity" placeholder="Please specify activity">
                    </div>
                    <div class="form-group mt-3">
                        <label for="observer_category"><i class="bx bx-user-pin"></i> Observer Category</label>
                        <select class="form-select" id="observer_category" name="observer_category" required>
                            <option value="">Select Observer</option>
                            <option value="Fisherfolks">Fisherfolks</option>
                            <option value="Barangay residents">Barangay Residents</option>
                            <option value="Local government">Local Government</option>
                            <option value="Advocacy groups">Advocacy Group</option>
                            <option value="Researcher">Researcher</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_observer" name="custom_observer" placeholder="Please specify observer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backBtn3"><i class="bx bx-chevron-left"></i> Back</button>
                    <button type="button" class="btn btn-primary" id="nextBtn3">Next <i class="bx bx-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Location & Media -->
    <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
        <div class="modal-dialog"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal4Label"><i class="bx bx-camera"></i> Location & Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('partials.wizard-steps', ['activeStep' => 4])

                    <div class="form-group">
                        <label><i class="bx bx-current-location"></i> Selected Location</label>
                        <div class="loc-readout">
                            <i class="bx bx-map-pin"></i>
                            <span><strong>Lat:</strong> <span id="latitude_display">Not selected</span> &nbsp;&bull;&nbsp; <strong>Lng:</strong> <span id="longitude_display">Not selected</span></span>
                        </div>
                        <input type="hidden" id="latitude" name="latitude" required>
                        <input type="hidden" id="longitude" name="longitude" required>
                    </div>

                    <div class="form-group">
                        <label for="photo"><i class="bx bx-image-alt"></i> Photos</label>
                        <input type="file" class="form-control" id="photo" name="photo[]" accept="image/*" multiple>
                        <div id="photo-previews" class="d-flex flex-wrap mt-2"></div>
                    </div>
                    <div class="form-group">
                        <label for="description"><i class="bx bx-message-rounded-detail"></i> Additional Comments</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backBtn4"><i class="bx bx-chevron-left"></i> Back</button>
                    <button type="submit" class="btn btn-success"><i class="bx bx-check"></i> Submit</button>
                </div>
                </form>   
            </div>
        </div>
    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
    // Fetch and display municipalities in Southern Leyte
    function populateMunicipalities() {
        fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
            .then(response => response.json())
            .then(data => {
                const municipalitySelect = document.getElementById('municipality');
                municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                data.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.name; // Use municipality name as the value
                    option.textContent = municipality.name; // Municipality name
                    municipalitySelect.appendChild(option);
                });

                // Load previously selected municipality from localStorage
                const savedMunicipality = localStorage.getItem('municipality');
                if (savedMunicipality) {
                    municipalitySelect.value = savedMunicipality;
                    populateBarangays(savedMunicipality);
                }
            })
            .catch(error => console.error('Error fetching municipalities:', error));
    }

    // Fetch and display barangays of selected municipality
    function populateBarangays(municipalityName) {
        fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
            .then(response => response.json())
            .then(data => {
                const municipality = data.find(municipality => municipality.name === municipalityName);
                if (municipality) {
                    const municipalityCode = municipality.code;
                    fetch(`https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays/`)
                        .then(response => response.json())
                        .then(barangays => {
                            const barangaySelect = document.getElementById('barangay');
                            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                            barangays.forEach(barangay => {
                                const option = document.createElement('option');
                                option.value = barangay.name; // Use barangay name as the value
                                option.textContent = barangay.name; // Barangay name
                                barangaySelect.appendChild(option);
                            });

                            // Load previously selected barangay from localStorage
                            const savedBarangay = localStorage.getItem('barangay');
                            if (savedBarangay) {
                                barangaySelect.value = savedBarangay;
                            }
                        })
                        .catch(error => console.error('Error fetching barangays:', error));
                }
            })
            .catch(error => console.error('Error fetching municipalities:', error));
    }

    // Event listener for municipality selection
    document.addEventListener('DOMContentLoaded', () => {
        // Set up event listener to store selected municipality name in localStorage
        document.getElementById('municipality').addEventListener('change', function () {
            const municipalityName = this.value; // Get selected municipality name
            localStorage.setItem('municipality', municipalityName); // Save name to localStorage
            if (municipalityName) {
                populateBarangays(municipalityName);
            } else {
                document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
                localStorage.removeItem('barangay'); // Clear selected barangay
            }
        });

        // Set up event listener to store selected barangay name in localStorage
        document.getElementById('barangay').addEventListener('change', function () {
            const barangayName = this.value; // Get selected barangay name
            localStorage.setItem('barangay', barangayName); // Save name to localStorage
        });

        populateMunicipalities(); // Load Southern Leyte municipalities on page load
    });
</script>



  
  
    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>


    <script>
    function switchModal(hideId, showId) {
        let hideModal = bootstrap.Modal.getInstance(document.getElementById(hideId));
        if (hideModal) hideModal.hide();
        
        let showModal = new bootstrap.Modal(document.getElementById(showId));
        showModal.show();
    }

    document.getElementById("nextBtn1").addEventListener("click", function () {
        let date = document.getElementById("date_of_sighting").value;
        let time = document.getElementById("time_of_sighting").value;
        let municipality = document.getElementById("municipality").value;
        let barangay = document.getElementById("barangay").value;

        if (date === "" || time === "" || municipality === "" || barangay === "") {
            alert("Please fill out all required fields.");
        } else {
            switchModal('modal1', 'modal2');
        }
    });

    document.getElementById("backBtn2").addEventListener("click", function () {
        switchModal('modal2', 'modal1');
    });

    document.getElementById("nextBtn2").addEventListener("click", function () {
        switchModal('modal2', 'modal3');
    });

    document.getElementById("backBtn3").addEventListener("click", function () {
        switchModal('modal3', 'modal2');
    });

    document.getElementById("nextBtn3").addEventListener("click", function () {
        switchModal('modal3', 'modal4');
    });

    document.getElementById("backBtn4").addEventListener("click", function () {
        switchModal('modal4', 'modal3');
    });
</script>


    <script>
    // Initialize the map
    var map = L.map('map').setView([10.306812602471465, 125.00810623168947], 12);

    // OSM layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    // Add Locate control
    L.control.locate().addTo(map);


    var geoJsonPolygon = {
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Polygon",
                "coordinates": [
                    [
                        [
                        124.98882706137022,10.398399643957603],
                        [124.96538337058183,10.38719952081739],
                        [124.95600589426613,10.347007542865796],
                        [124.97074192847674,10.29890218090081],
                        [124.97141174821303,10.263312667596836],
                        [124.97141174821303,10.205965592498274],
                        [124.98212886400279,10.159816761533278],
                        [124.99820453768757,10.119595918359465],
                        [125.01026129294985,10.085305317819461],
                        [125.00892165347574,10.032543423636369],
                        [125.01495003110864,9.996924282406624],
                        [125.07389416794933,9.884104645319326],
                        [125.18709370347563,9.870246924008114],
                        [125.27082117058052,9.870906828729844],
                        [125.27617972847554,9.904560213998522],
                        [125.2547454968975,9.965259545956073],
                        [125.19178244163419,10.068158647849856],
                        [125.13953650216087,10.103769941717204],
                        [125.13082884558139,10.195417877137956],
                        [125.01762931005521,10.400376094583976],
                        [125.0028932758446,10.403011342620147],
                        [124.98882706137022,10.398399643957603]  
                    ]
                ]
            }
        }
    ]
};
// Add the slightly larger GeoJSON polygon to the map
var polygon = L.geoJSON(geoJsonPolygon, {
    style: function () {
        return {
            color: "#0000FF",  // Border color (still defined, but will be invisible)
            weight: 2,         // Border thickness
            opacity: 0,        // Make the border fully transparent
            fillOpacity: 0     // No fill color
        };
    }
}).addTo(map);

// Fit map to the new polygon bounds
map.fitBounds(polygon.getBounds());

    // Loop through each location from the backend and add markers
    var sightingsGroup = L.featureGroup().addTo(map);
    var sightings = [];

    @foreach ($locations as $location)
    sightings.push({
        municipality: @json($location->municipality),
        date: @json($location->date_of_sighting),
        marker: L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).bindTooltip('{{ addslashes($location->name ?: $location->barangay) }}')
    });
    @endforeach

    function applyFilters() {
        var m = document.getElementById('filterMunicipality').value;
        var d = document.getElementById('filterDate').value;
        var shown = 0;
        sightings.forEach(function (s) {
            var match = (!m || s.municipality === m) && (!d || s.date === d);
            if (match) {
                sightingsGroup.addLayer(s.marker);
                shown++;
            } else {
                sightingsGroup.removeLayer(s.marker);
            }
        });
        document.getElementById('filterCount').textContent = shown + ' of ' + sightings.length + ' sightings';
    }

    function clearFilters() {
        document.getElementById('filterMunicipality').value = '';
        document.getElementById('filterDate').value = '';
        applyFilters();
    }

    applyFilters();

// Global marker variable for new markers
var marker;

// Click event to place a new marker
map.on('click', function (e) {
    var clickedPoint = e.latlng;

    // Check if the clicked point is inside the polygon
    var inside = false;
    polygon.eachLayer(function (layer) {
        if (layer.getBounds().contains(clickedPoint)) {
            inside = true;
        }
    });

    if (inside) {
        if (marker) {
            map.removeLayer(marker); // Remove existing marker
        }
        marker = L.marker(clickedPoint).addTo(map); // Place new marker

        // Temporarily store the coordinates
        document.getElementById('latitude').value = clickedPoint.lat;
        document.getElementById('longitude').value = clickedPoint.lng;


        document.getElementById('latitude_display').textContent = clickedPoint.lat.toFixed(6);
        document.getElementById('longitude_display').textContent = clickedPoint.lng.toFixed(6);


        // Show the consent modal
        $('#consentModal').modal('show');
    } else {
        alert("You can only place markers inside the sogod bay.");
    }
});

// Handle "Agree" button click in consent modal
document.getElementById('agreeConsent').addEventListener('click', function () {
    $('#consentModal').modal('hide'); // Hide consent modal
    $('#modal1').modal('show'); // Show location modal
});

// Handle "Cancel" button in consent modal
document.querySelector('.btn-secondary[data-bs-dismiss="modal"]').addEventListener('click', function () {
    if (marker) {
        map.removeLayer(marker); // Remove marker if consent is not given
        marker = null;
    }
    });
</script>

<script>
    // Function to toggle custom input visibility based on selection
    document.getElementById('activity_type').addEventListener('change', function() {
        var activitySelect = document.getElementById('activity_type');
        var customActivityInput = document.getElementById('custom_activity');
        if (activitySelect.value === 'other') {
            customActivityInput.classList.remove('d-none');
        } else {
            customActivityInput.classList.add('d-none');
        }
    });

    document.getElementById('observer_category').addEventListener('change', function() {
        var observerSelect = document.getElementById('observer_category');
        var customObserverInput = document.getElementById('custom_observer');
        if (observerSelect.value === 'other') {
            customObserverInput.classList.remove('d-none');
        } else {
            customObserverInput.classList.add('d-none');
        }
    });

    // When the form is submitted, append the custom input value if provided
    document.querySelector('form').addEventListener('submit', function() {
        // If "Other" is selected for activity type and custom input is provided
        var activitySelect = document.getElementById('activity_type');
        var customActivityInput = document.getElementById('custom_activity');
        if (activitySelect.value === 'other' && customActivityInput.value) {
            activitySelect.value = customActivityInput.value; // Override the value with the custom input
        }

        // If "Other" is selected for observer category and custom input is provided
        var observerSelect = document.getElementById('observer_category');
        var customObserverInput = document.getElementById('custom_observer');
        if (observerSelect.value === 'other' && customObserverInput.value) {
            observerSelect.value = customObserverInput.value; // Override the value with the custom input
        }
    });

        document.getElementById('photo').addEventListener('change', function(event) {
        var fileList = event.target.files;
        var previewContainer = document.getElementById('photo-previews');
        previewContainer.innerHTML = ''; // Clear previous previews

        // Loop through the selected files
        for (var i = 0; i < fileList.length; i++) {
            var file = fileList[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'rounded', 'm-2');
                img.style.maxWidth = '150px';
                previewContainer.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    });

</script>
<script>
    // Function to update the total of COTS
    function updateTotal() {
        // Get values from the input fields and parse them as integers (default to 0 if empty)
        let earlyJuvenile = parseInt(document.getElementById('early_juvenile').value) || 0;
        let juvenile = parseInt(document.getElementById('juvenile').value) || 0;
        let subAdult = parseInt(document.getElementById('sub_adult').value) || 0;
        let adult = parseInt(document.getElementById('adult').value) || 0;
        let lateadult = parseInt(document.getElementById('late_adult').value) || 0;


        // Calculate the total
        let total = earlyJuvenile + juvenile + subAdult + adult + lateadult;

        // Update the total field
        document.getElementById('number_of_cots').value = total;
    }

    // Attach the updateTotal function to the input event for each relevant field
    document.getElementById('early_juvenile').addEventListener('input', updateTotal);
    document.getElementById('juvenile').addEventListener('input', updateTotal);
    document.getElementById('sub_adult').addEventListener('input', updateTotal);
    document.getElementById('adult').addEventListener('input', updateTotal);
    document.getElementById('late_adult').addEventListener('input', updateTotal);


</script>

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    

@endsection