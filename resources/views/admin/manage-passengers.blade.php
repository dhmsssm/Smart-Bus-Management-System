@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            👥 Manage Passengers
        </h2>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($passengers as $passenger)

                        <tr>

                            <td>{{ $passenger->id }}</td>

                            <td>{{ $passenger->name }}</td>

                            <td>{{ $passenger->email }}</td>

                            <td>{{ $passenger->phone }}</td>

                            <td>

                                <a href="/admin/passengers/view/{{ $passenger->id }}"
                                   class="btn btn-info btn-sm">

                                    View

                                </a>

                                <a href="/admin/passengers/delete/{{ $passenger->id }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this passenger?')">

                                    Delete

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No Passengers Found

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection