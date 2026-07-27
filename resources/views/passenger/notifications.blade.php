<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #F5F7FB;
            color: #333;
        }
        .notification-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
        }
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">
                <i class="bi bi-bell-fill text-warning me-2"></i> Notifications
            </h2>
            <p class="text-muted small mb-0">Keep track of your bus booking status and updates</p>
        </div>
        <a href="/passenger/dashboard" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    @forelse($notifications as $notification)
        @php
            $msg = strtolower($notification->message);
            $isCancel = str_contains($msg, 'cancel');
            $isConfirm = str_contains($msg, 'confirm') || str_contains($msg, 'success');
            
            if ($isCancel) {
                $iconClass = 'bi-exclamation-triangle-fill';
                $iconColor = '#dc3545';
                $iconBg = '#fdf2f2';
            } elseif ($isConfirm) {
                $iconClass = 'bi-check-circle-fill';
                $iconColor = '#198754';
                $iconBg = '#eafaf1';
            } else {
                $iconClass = 'bi-bell-fill';
                $iconColor = '#0d6efd';
                $iconBg = '#edf5ff';
            }
        @endphp
        <div class="card notification-card shadow-sm mb-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-start">
                    <div class="icon-box me-3" style="background: {{ $iconBg }}; color: {{ $iconColor }};">
                        <i class="bi {{ $iconClass }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold text-dark" style="line-height: 1.5;">
                            {{ $notification->message }}
                        </h6>
                        <small class="text-muted d-flex align-items-center">
                            <i class="bi bi-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info rounded-3 border-0 py-3 shadow-sm">
            <i class="bi bi-info-circle-fill me-2"></i> No Notifications Found
        </div>
    @endforelse
</div>

</body>
</html>
