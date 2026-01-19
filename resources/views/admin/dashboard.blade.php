@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="text-center py-5">
    <div class="alert alert-primary">
        <h2><i class="fas fa-user-shield me-2"></i>Dashboard Admin</h2>
        <p class="mb-0">Placeholder untuk halaman dashboard administrator</p>
    </div>
</div>
@endsection