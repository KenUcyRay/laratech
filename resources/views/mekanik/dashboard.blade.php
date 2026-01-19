@extends('layouts.app')

@section('title', 'Mekanik Dashboard')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
<div class="text-center py-5">
    <div class="alert alert-warning">
        <h2><i class="fas fa-wrench me-2"></i>Dashboard Mekanik</h2>
        <p class="mb-0">Placeholder untuk halaman dashboard mekanik</p>
    </div>
</div>
@endsection