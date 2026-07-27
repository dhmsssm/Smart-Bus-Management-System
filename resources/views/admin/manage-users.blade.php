@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            👥 Manage Users
        </h2>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr>

                            <td>{{ $user->id }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>{{ $user->phone ?? 'N/A' }}</td>

                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'driver' ? 'warning text-dark' : 'info') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td>
                                @if($user->role !== 'admin')
                                    <a href="/admin/users/delete/{{ $user->id }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this user?')">
                                        Delete
                                    </a>
                                @else
                                    <span class="text-muted">No Action</span>
                                @endif
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Users Found

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
