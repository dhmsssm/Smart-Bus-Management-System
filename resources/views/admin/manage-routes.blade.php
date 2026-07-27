@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">

        🛣 Manage Routes

    </h2>

    <a href="/admin/routes/create"
    class="btn btn-success">

        + Add Route

    </a>

</div>

<div class="card shadow-sm">

<div class="card-body">

<table class="table table-bordered">

<thead class="table-success">

<tr>

<th>ID</th>
<th>Route</th>
<th>Start</th>
<th>End</th>
<th>Distance</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($routes as $route)

<tr>

<td>{{ $route->id }}</td>

<td>{{ $route->route_name }}</td>

<td>{{ $route->start_location }}</td>

<td>{{ $route->end_location }}</td>

<td>{{ $route->distance }} KM</td>

<td>

<a href="/admin/routes/edit/{{ $route->id }}"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="/admin/routes/delete/{{ $route->id }}"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection