@extends('layouts.app')

@section('content')

<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="card mb-4" style="border: none; border-radius: 18px; overflow: hidden; background: linear-gradient(120deg, #001e3c 0%, #00447a 60%, #0a5bac 100%);">
        <div class="card-body p-4 text-white d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="mb-1" style="font-weight: 800;"><i class="bx bx-bar-chart-alt me-2"></i>Sightings Report</h4>
                <small class="text-white-50">Browse all reported COTS sightings across Southern Leyte.</small>
            </div>
            <a href="{{ route('admin.report.export', ['municipality' => request('municipality')]) }}" class="btn btn-light fw-semibold" style="color: #003049;">
                <i class="bx bx-download me-1"></i> Export
            </a>
        </div>
    </div>

    <!-- Card for Location Report -->
    <div class="card" style="border: none; border-radius: 18px; box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);">

        <!-- Toolbar: filter + count -->
        <div class="card-body pb-0">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <form method="GET" action="{{ route('admin.report') }}" class="d-flex align-items-center gap-2" id="filterForm">
                    <label for="municipality" class="form-label small text-muted mb-0 fw-semibold">Municipality:</label>
                    <select name="municipality" id="municipality" class="form-select" style="min-width: 220px;" onchange="this.form.submit()">
                        <option value="">All municipalities</option>
                        @foreach($municipalities as $municipality)
                            <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                                {{ $municipality }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('municipality'))
                        <a href="{{ route('admin.report') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-reset"></i> Clear
                        </a>
                    @endif
                </form>
                <span class="ms-auto text-muted small">
                    <span class="badge rounded-pill text-white" style="background: #0056b3;">{{ $locations->total() }}</span>
                    records
                    @if(request('municipality'))
                        in <strong>{{ request('municipality') }}</strong>
                    @endif
                </span>
            </div>
        </div>

        <!-- Table for Locations -->
        <div class="table-responsive px-3 pb-1">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 30%;">Municipality where COTS are Sighted</th>
                        <th style="width: 15%;">Number of Cots</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 15%;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr>
                            <td class="text-muted">{{ $locations->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $location->name ?? $location->barangay }}</td>
                            <td>{{ $location->municipality }}</td>
                            <td><span class="badge text-white" style="background: #0056b3;">{{ $location->number_of_cots }}</span></td>
                            <td>{{ $location->date_of_sighting }}</td>
                            <td>{{ $location->time_of_sighting }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bx bx-current-location fs-1"></i>
                                <p class="mt-2 mb-0">No sightings to show for this filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center py-3">
            {{ $locations->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection