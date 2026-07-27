@extends('layouts.app')

@section('content')

{{ Auth::check() ? 'LOGIN OK' : 'LOGIN FAIL' }}


<div class="container-fluid">

<h2 class="fw-bold mb-4">

👨‍✈️ Add Driver

</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="/admin/drivers/store" method="POST">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

</div>

<button
class="btn btn-success">

Save Driver

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