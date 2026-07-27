<div class="topbar">
    <button class="btn btn-outline-success d-lg-none me-3"
            id="menuToggle">
        <i class="bi bi-list"></i>
    </button>

    <button class="btn btn-outline-secondary me-3 d-none d-lg-block"
            id="desktopToggle">
        <i class="bi bi-list"></i>
    </button>

    <div>
        <h5 class="mb-0 fw-semibold">Admin Dashboard</h5>
        <small class="text-muted">BusLink management console</small>
    </div>

    <div class="profile">
        <div class="avatar">



            {{ Auth::check() ? strtoupper(substr(Auth::user()->name,0,1)) : 'A' }}

        </div>

        <div>
            <strong>{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</strong>
            <br>
            <small class="text-muted">Admin</small>
        </div>
    </div>
</div>
