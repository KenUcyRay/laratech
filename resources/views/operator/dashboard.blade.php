@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

 <div class="mb-5">
    <div class="bg-dark rounded p-4 mb-4 shadow text-center" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
        <div class="d-flex align-items-center justify-content-center">
            <div>
                <h2 class="text-white fw-bold mb-1">Dashboard Operator</h2>
                <p class="text-white-50 mb-0">
                    Pantau dan kelola aktivitas operasional hari ini
                </p>
            </div>
        </div>
    </div>
</div>


    @include('operator.partials.summary-cards')

</div>
@endsection
