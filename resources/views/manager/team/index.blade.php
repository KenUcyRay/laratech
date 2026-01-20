@extends('layouts.app')

@section('title', 'Team Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            @include('components.manager-sidebar')
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Team Management</h1>
            </div>

            <!-- Operators Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Operators</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Total Tasks</th>
                                    <th>Pending Tasks</th>
                                    <th>Completed Tasks</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operators as $operator)
                                <tr>
                                    <td>{{ $operator->name }}</td>
                                    <td>{{ $operator->username }}</td>
                                    <td>{{ $operator->total_tasks }}</td>
                                    <td>
                                        <span class="badge badge-warning">{{ $operator->pending_tasks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $operator->completed_tasks }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $performance = $operator->total_tasks > 0 ? 
                                                round(($operator->completed_tasks / $operator->total_tasks) * 100) : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($performance >= 80) bg-success 
                                                @elseif($performance >= 60) bg-warning 
                                                @else bg-danger @endif" 
                                                style="width: {{ $performance }}%">
                                                {{ $performance }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mekaniks Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mekaniks</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Total Tasks</th>
                                    <th>Pending Tasks</th>
                                    <th>Completed Tasks</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mekaniks as $mekanik)
                                <tr>
                                    <td>{{ $mekanik->name }}</td>
                                    <td>{{ $mekanik->username }}</td>
                                    <td>{{ $mekanik->total_tasks }}</td>
                                    <td>
                                        <span class="badge badge-warning">{{ $mekanik->pending_tasks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $mekanik->completed_tasks }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $performance = $mekanik->total_tasks > 0 ? 
                                                round(($mekanik->completed_tasks / $mekanik->total_tasks) * 100) : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($performance >= 80) bg-success 
                                                @elseif($performance >= 60) bg-warning 
                                                @else bg-danger @endif" 
                                                style="width: {{ $performance }}%">
                                                {{ $performance }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection