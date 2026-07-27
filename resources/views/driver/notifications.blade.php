@extends('layouts.app')

@section('content')

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Notifications
            </h2>

            <p class="text-muted mb-0">
                View driver notifications and manage read status.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-bell-fill text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif

@forelse($notifications as $notification)

    <div class="card notification-card shadow-sm border-0 mb-3">

        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">

                <div class="d-flex">

                    <div class="avatar me-3 {{ $notification->read_at ? 'bg-secondary' : '' }}">
                        <i class="bi bi-bell-fill"></i>
                    </div>

                    <div>

                        <h6 class="fw-semibold mb-1">
                            {{ $notification->message }}
                        </h6>

                        <small class="text-muted">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>

                        <div class="mt-2">
                            @if($notification->read_at)
                                <span class="badge bg-secondary">
                                    Read
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Unread
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2">

                    @if(! $notification->read_at)

                        <form method="POST" action="{{ route('driver.notifications.read', $notification) }}">
                            @csrf

                            <button class="btn btn-outline-success btn-sm">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Mark as Read
                            </button>

                        </form>

                    @endif

                    <form method="POST" action="{{ route('driver.notifications.delete', $notification) }}">
                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Delete this notification?')">

                            <i class="bi bi-trash-fill me-1"></i>
                            Delete

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@empty

    <div class="alert alert-info">
        No Notifications Found
    </div>

@endforelse

@endsection
