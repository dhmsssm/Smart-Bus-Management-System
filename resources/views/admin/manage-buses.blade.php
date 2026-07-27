@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">

        🚌 Manage Buses

    </h2>

    <a href="/admin/buses/create" class="btn btn-success">

        + Add New Bus

    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead class="table-success">

                <tr>

                    <th>ID</th>

                    <th>Bus Number</th>

                    <th>Capacity</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            @forelse($buses as $bus)

                <tr>

                    <td>{{ $bus->id }}</td>

                    <td>{{ $bus->bus_number }}</td>

                    <td>{{ $bus->capacity }}</td>

                    <td>

                        <span class="badge bg-success">

                            {{ $bus->status }}

                        </span>

                    </td>

                    <td>

                        <a href="/admin/buses/edit/{{ $bus->id }}"
                        class="btn btn-warning btn-sm">

                            Edit

                        <a href="/admin/buses/delete/{{ $bus->id }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this bus?')">

    <i class="bi bi-trash"></i>

    Delete

</a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center">

                        No buses found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection