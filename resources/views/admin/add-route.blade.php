@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-signpost-split-fill text-success"></i>

            Add New Route

        </h2>

        <a href="/admin/routes"
        class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <form action="/admin/routes/store" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Route Name

                        </label>

                        <input
                        type="text"
                        name="route_name"
                        class="form-control"
                        required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Distance (KM)

                        </label>

                        <input
                        type="number"
                        step="0.01"
                        name="distance"
                        class="form-control"
                        required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Start Location

                        </label>

                        <input
                        type="text"
                        name="start_location"
                        class="form-control"
                        required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            End Location

                        </label>

                        <input
                        type="text"
                        name="end_location"
                        class="form-control"
                        required>

                    </div>

                </div>

                <button
                type="submit"
                class="btn btn-success">

                    <i class="bi bi-check-circle"></i>

                    Save Route

                </button>

                <a href="/admin/routes"
                class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection