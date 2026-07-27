
<div class="topbar">


<button class="btn btn-outline-success d-lg-none me-3"
        id="menuToggle">

    <i class="bi bi-list"></i>

</button>

<button
class="btn btn-outline-secondary me-3 d-none d-lg-block"
id="desktopToggle">

<i class="bi bi-list"></i>

</button>





    <div class="search-box">

        <div class="input-group">

            <span class="input-group-text bg-white border-end-0">

                <i class="bi bi-search"></i>

            </span>

            <input
                type="text"
                class="form-control border-start-0"
                placeholder="Search buses, routes...">

        </div>

    </div>

    <div class="profile">

        <button class="btn position-relative">

            <i class="bi bi-bell-fill fs-5"></i>

            @if(isset($notificationsCount) && $notificationsCount > 0)

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                    {{ $notificationsCount }}

                </span>

            @endif

        </button>

        <div class="avatar">

            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

        </div>

        <div>

            <strong>

                {{ Auth::user()->name }}

            </strong>

            <br>

            <small class="text-muted">

                {{ ucfirst(Auth::user()->role) }}

            </small>

        </div>

    </div>

</div>

