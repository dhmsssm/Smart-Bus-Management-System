<div class="sidebar">

    <div class="logo">
        <i class="bi bi-bus-front-fill me-2" style="color: #6366f1;"></i>
        SmartBus
        <small>Admin Panel</small>
    </div>

    <div class="sidebar-menu">

        <a href="/admin/dashboard"
        class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            <span class="menu-text">Dashboard</span>

        </a>

        <a href="/admin/buses"
        class="{{ request()->is('admin/buses*') ? 'active' : '' }}">

            <i class="bi bi-bus-front-fill"></i>

            <span class="menu-text">Manage Buses</span>

        </a>

        <a href="/admin/routes"
        class="{{ request()->is('admin/routes*') ? 'active' : '' }}">

            <i class="bi bi-signpost-split-fill"></i>

            <span class="menu-text">Manage Routes</span>

        </a>





        <a href="/admin/bus-location"
        class="{{ request()->is('admin/bus-location') ? 'active' : '' }}">

            <i class="bi bi-geo-alt-fill"></i>

            <span class="menu-text">Live Tracking</span>

        </a>

        <a href="/admin/drivers"
        class="{{ request()->is('admin/drivers*') ? 'active' : '' }}">

            <i class="bi bi-person-badge-fill"></i>

            <span class="menu-text">Manage Drivers</span>

        </a>

        <a href="/admin/passengers"
        class="{{ request()->is('admin/passengers*') ? 'active' : '' }}">

            <i class="bi bi-people-fill"></i>

            <span class="menu-text">Manage Passengers</span>

        </a>

        <a href="/admin/bookings"
        class="{{ request()->is('admin/bookings*') ? 'active' : '' }}">

            <i class="bi bi-ticket-perforated-fill"></i>

            <span class="menu-text">Bookings</span>

        </a>

        <a href="/admin/ticket-sales-prediction"
        class="{{ request()->is('admin/ticket-sales-prediction*') ? 'active' : '' }}">

            <i class="bi bi-bar-chart-line-fill"></i>

            <span class="menu-text">Ticket Sales Prediction</span>

        </a>

        <hr class="text-secondary">

        <a href="/logout">

            <i class="bi bi-box-arrow-right"></i>

            <span class="menu-text">Logout</span>

        </a>

    </div>

</div>