
<div class="sidebar">

    <div class="logo">

        <i class="bi bi-bus-front-fill me-2" style="color: #3b82f6;"></i> SmartBus

        <small>
            Smart Bus Management
        </small>

    </div>

    <div class="sidebar-menu">

        <a href="/passenger/dashboard"
           class="{{ request()->is('passenger/dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            <span class="menu-text">
            Dashboard
            </span>

        </a>

        <a href="/search-buses"
           class="{{ request()->is('search-buses') ? 'active' : '' }}">

            <i class="bi bi-search"></i>

            <span class="menu-text">
            Search Buses
            </span>

        </a>

        <a href="/my-bookings"
           class="{{ request()->is('my-bookings') ? 'active' : '' }}">

            <i class="bi bi-ticket-perforated-fill"></i>

           <span class="menu-text">
          My Bookings
          </span>

        </a>

        <a href="/live-tracking"
           class="{{ request()->is('live-tracking') ? 'active' : '' }}">

            <i class="bi bi-geo-alt-fill"></i>

            <span class="menu-text">
            Live Tracking
            </span>

        </a>

        <a href="/notifications"
           class="{{ request()->is('notifications') ? 'active' : '' }}">

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

        <a href="/passenger/profile"
           class="{{ request()->is('passenger/profile') ? 'active' : '' }}">

            <i class="bi bi-person-fill"></i>

            <span class="menu-text">
            My Profile
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

<!-- no need this one
    
.sidebar-menu a{

display:flex;

align-items:center;

gap:12px;

padding:15px 25px;

color:white;

text-decoration:none;

border-left:4px solid transparent;

transition:.3s;

}

.sidebar-menu a:hover{

background:#16213E;

border-left:4px solid #16C47F;

padding-left:30px;

}
--!>
