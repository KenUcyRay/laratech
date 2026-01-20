@extends('layouts.app')

@section('title', 'Inventory Equipment')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Equipment List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $equipment)
                            <tr>
                                <td>{{ $equipment->code }}</td>
                                <td>{{ $equipment->name }}</td>
                                <td>{{ $equipment->type->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $equipment->status == 'operasi' ? 'success' : ($equipment->status == 'rusak' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($equipment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary update-status-btn" data-id="{{ $equipment->id }}"
                                        data-status="{{ $equipment->status }}">
                                        Update Status
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            
        </script>
    @endpush
@endsection