@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">

        👨‍✈️ Manage Drivers

    </h2>

    <a href="/admin/drivers/create"
    class="btn btn-success">

        + Add Driver

    </a>

</div>

<div class="card shadow-sm">

<div class="card-body">

<table class="table table-bordered">

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

@forelse($drivers as $driver)

<tr>

<td>{{ $driver->id }}</td>

<td>{{ $driver->name }}</td>

<td>{{ $driver->email }}</td>

<td>{{ $driver->phone }}</td>

<td>

<a href="/admin/drivers/edit/{{ $driver->id }}"
class="btn btn-warning btn-sm">

Edit

<a href="/admin/drivers/delete/{{ $driver->id }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this driver?')">

    Delete

</a>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center">

No Drivers Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection