@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 550px; background: white;">
        <div class="card-body">
            <!-- Icon / Illustration -->
            <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; background-color: rgba(99, 102, 241, 0.1);">
                <i class="bi bi-bar-chart-line" style="font-size: 3rem; color: #6366f1;"></i>
            </div>

            <!-- Title & Badge -->
            <div class="mb-3 d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <h3 class="fw-bold m-0" style="color: #0f172a;">Ticket Sales Prediction</h3>
                <span class="badge text-white px-3 py-2 rounded-pill" style="background-color: #6366f1; font-size: 0.8rem;">Coming Soon</span>
            </div>

            <!-- Description Message -->
            <p class="text-muted fs-6 mb-4 px-3" style="line-height: 1.6;">
                This feature is currently under development. <br>
                In a future release, Machine Learning will be used to predict ticket sales based on historical booking data.
            </p>

            <!-- Buttons -->
            <div class="d-grid gap-3 col-10 mx-auto">
                <button type="button" class="btn btn-secondary py-2.5 rounded-3 fw-medium" disabled style="opacity: 0.65;">
                    <i class="bi bi-cpu me-2"></i>Generate Prediction
                </button>
                <a href="/admin/dashboard" class="btn btn-outline-secondary py-2.5 rounded-3 fw-medium">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
