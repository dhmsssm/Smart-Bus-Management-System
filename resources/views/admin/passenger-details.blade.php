@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            👤 Passenger Details

        </h2>

        <a href="/admin/passengers"
        class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="250">Name</th>
                    <td>{{ $passenger->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $passenger->email }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $passenger->phone }}</td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>{{ ucfirst($passenger->role) }}</td>
                </tr>

                <tr>
                    <th>Registered Date</th>
                    <td>{{ $passenger->created_at }}</td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection