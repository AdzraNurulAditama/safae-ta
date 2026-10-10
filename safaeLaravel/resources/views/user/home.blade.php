@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h4>Selamat Datang, {{ $user['nama_depan'] }} {{ $user['nama_belakang'] }} 👋</h4>
            <p class="text-muted">Username: {{ $user['username'] }}</p>
            <p>Email: {{ $user['email'] }}</p>
        </div>
    </div>
</div>
@endsection
