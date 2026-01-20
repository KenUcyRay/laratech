@extends('layouts.app')

@section('title', 'Work Orders')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Active Work Orders</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Priority</th>
                            <th>Title</th>
                            <th>Equipment</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr class="{{ $task->priority == 'high' ? 'table-danger' : '' }}">
                                <td>
                                    <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : 'info' }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->equipment->name ?? '-' }}</td>
                                <td>{{ ucfirst($task->status) }}</td>
                                <td>{{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($task->status == 'todo')
                                        <button class="btn btn-sm btn-primary start-task-btn" data-id="{{ $task->id }}">
                                            Start
                                        </button>
                                    @elseif($task->status == 'doing')
                                        <button class="btn btn-sm btn-success complete-task-btn" data-id="{{ $task->id }}">
                                            Complete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection