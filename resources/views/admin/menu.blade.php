<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo py-3 px-2 border-bottom">
        <a href="javascript:void(0);" class="sidebar-toggle me-2"><i class="bx bx-menu bx-sm"></i></a>
        <a href="{{ route('admin.index') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <span class="brand-logo-chip"><img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" style="height: 46px; width: auto;"></span>
            <span class="menu-text fw-bolder ms-3 fs-5">COTS Tracker</span>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-section-label">Menu</li>
        <li class="menu-item {{ Route::is('admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link text-decoration-none">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.location') ? 'active' : '' }}">
            <a href="{{ route('admin.location') }}" class="menu-link text-decoration-none">
                <i class="menu-icon tf-icons bx bx-location-plus"></i>
                <div data-i18n="Map">Sightings Map</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.report') ? 'active' : '' }}">
            <a href="{{ route('admin.report') }}" class="menu-link text-decoration-none">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
                <div data-i18n="Report">Report</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.adduser') ? 'active' : '' }}">
            <a href="{{ route('admin.adduser') }}" class="menu-link text-decoration-none">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Users">Manage Users</div>
            </a>
        </li>
        <li class="menu-section-label">Reports</li>
        <li class="menu-item {{ Route::is('admin.download') ? 'active' : '' }}">
            <a href="{{ route('admin.download') }}" class="menu-link text-decoration-none">
                <i class="menu-icon tf-icons bx bx-download"></i>
                <div data-i18n="Download">Download</div>
            </a>
        </li>
        <li class="menu-section-label">Account</li>
        <li class="menu-item mt-1">
            <a href="{{ route('logout') }}" class="menu-link text-decoration-none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>