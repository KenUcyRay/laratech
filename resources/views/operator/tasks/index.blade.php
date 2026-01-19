<h1>Tugas Saya</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Equipment</th>
            <th>Judul Task</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tasks as $task)
            <tr>
                <td>{{ $task->equipment->name }} ({{ $task->equipment->code }})</td>
                <td>{{ $task->title }}</td>
                <td>{{ ucfirst($task->status) }}</td>
                <td>{{ ucfirst($task->priority) }}</td>
                <td>{{ $task->due_date ? $task->due_date->format('d/m/Y H:i') : '-' }}</td>
                <td>
                    <form action="{{ route('operator.tasks.updateStatus', $task->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()">
                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>Todo</option>
                            <option value="doing" {{ $task->status === 'doing' ? 'selected' : '' }}>Doing</option>
                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                            <option value="cancelled" {{ $task->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada task</td>
            </tr>
        @endforelse
    </tbody>
</table>