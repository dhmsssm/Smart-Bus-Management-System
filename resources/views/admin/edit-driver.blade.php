@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="fw-bold mb-4">
        👨‍✈️ Edit Driver
    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="/admin/drivers/update/{{ $driver->id }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Name</label>

                        <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ $driver->name }}"
                        required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Email</label>

                        <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ $driver->email }}"
                        required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Phone</label>

                        <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ $driver->phone }}"
                        required>

                    </div>

                </div>

                <button
                class="btn btn-warning">

                    Update Driver

                </button>

                <a href="/admin/drivers"
                class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection