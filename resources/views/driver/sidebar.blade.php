<div class="sidebar">

    <div class="logo">

        <i class="bi bi-bus-front-fill me-2" style="color: #10b981;"></i> SmartBus

        <small>
            Smart Bus Management
        </small>

    </div>

    <div class="sidebar-menu">

        <a href="/driver/dashboard"
           class="{{ request()->is('driver/dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            <span class="menu-text">
            Dashboard
            </span>

        </a>

        <a href="/driver/my-bus"
           class="{{ request()->is('driver/my-bus') ? 'active' : '' }}">

            <i class="bi bi-bus-front-fill"></i>

            <span class="menu-text">
            My Bus
            </span>

        </a>

        <a href="/driver/my-route"
           class="{{ request()->is('driver/my-route') ? 'active' : '' }}">

            <i class="bi bi-signpost-split-fill"></i>

            <span class="menu-text">
            My Route
            </span>

        </a>

        <a href="/driver/passengers"
           class="{{ request()->is('driver/passengers') ? 'active' : '' }}">

            <i class="bi bi-people-fill"></i>

            <span class="menu-text">
            Passengers
            </span>

        </a>

        <a href="/driver/location"
           class="{{ request()->is('driver/location') ? 'active' : '' }}">

            <i class="bi bi-geo-alt-fill"></i>

            <span class="menu-text">
            Update Location
            </span>

        </a>

        <a href="/driver/trip-history"
           class="{{ request()->is('driver/trip-history') ? 'active' : '' }}">

            <i class="bi bi-clock-history"></i>

            <span class="menu-text">
            Trip History
            </span>

        </a>

        <a href="/driver/notifications"
           class="{{ request()->is('driver/notifications') ? 'active' : '' }}">

            <i class="bi bi-bell-fill"></i>

            <span class="menu-text">
            Notifications
            </span>

            @if(isset($notificationsCount) && $notificationsCount > 0)

                <span class="badge bg-danger ms-auto">
                    {{ $notificationsCount }}
                </span>

            @endif

        </a>

        <a href="/driver/profile"
           class="{{ request()->is('driver/profile') ? 'active' : '' }}">

            <i class="bi bi-person-fill"></i>

            <span class="menu-text">
            Profile
            </span>

        </a>

        <hr class="text-secondary">

        <a href="/logout">

            <i class="bi bi-box-arrow-right"></i>

            <span class="menu-text">
            Logout
            </span>

        </a>

    </div>

</div>
