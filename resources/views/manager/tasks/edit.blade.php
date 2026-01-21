@extends('layouts.app')

@section('title', 'Edit Task')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="text-white fw-bold mb-0"><i class="fas fa-edit me-2"></i>Edit Task</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('manager.tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control rounded-3 border-2" name="title" value="{{ $task->title }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Equipment</label>
                                <select class="form-control rounded-3 border-2" name="equipment_id" required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipments as $equipment)
                                        <option value="{{ $equipment->id }}" {{ $task->equipment_id == $equipment->id ? 'selected' : '' }}>
                                            {{ $equipment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Assign To</label>
                                <select class="form-control rounded-3 border-2" name="assigned_to" required>
                                    <option value="">Select Person</option>
                                    @foreach($assignees as $assignee)
                                        <option value="{{ $assignee->id }}" {{ $task->assigned_to == $assignee->id ? 'selected' : '' }}>
                                            {{ $assignee->name }} ({{ ucfirst($assignee->role) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Priority</label>
                                <select class="form-control rounded-3 border-2" name="priority" required>
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Due Date</label>
                                <input type="date" class="form-control rounded-3 border-2" name="due_date" value="{{ $task->due_date }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-control rounded-3 border-2" name="status" required>
                                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Todo</option>
                                    <option value="doing" {{ $task->status == 'doing' ? 'selected' : '' }}>Doing</option>
                                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('manager.tasks.index') }}" class="btn btn-secondary rounded-3 me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection