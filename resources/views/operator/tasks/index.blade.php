@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #22c55e 0%, #10b981 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tasks" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="fas fa-clipboard-check text-white fs-4"></i>
                        </div>
                        <h1 class="fw-bold mb-0 text-white">Tugas Saya</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🚀 Kelola dan pantau progress tugas harian Anda dengan mudah
                    </p>
                </div>
                <button class="btn btn-light rounded-pill px-4 py-3 shadow" data-bs-toggle="modal" data-bs-target="#addTaskModal" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-plus me-2 text-success"></i>
                    <span class="fw-semibold text-dark">Buat Tugas</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Task Grid --}}
    <div id="taskList" class="row g-4 d-none">
        <!-- Tasks will be added here dynamically -->
    </div>

    {{-- Modern Empty State --}}
    <div id="emptyState" class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
            <i class="fas fa-clipboard-list fa-3x text-primary"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Belum ada tugas</h4>
        <p class="text-muted mb-4 fs-6">
            Mulai produktivitas Anda dengan membuat tugas pertama
        </p>
        <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fas fa-plus me-2"></i>Tambah Tugas Pertama
        </button>
    </div>

</div>

{{-- Modern Modal --}}
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <div class="text-center w-100">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-plus-circle fs-3 text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">✨ Buat Tugas Baru</h3>
                    <p class="text-muted mb-0 fs-6">Tambahkan detail tugas yang akan dikerjakan dengan lengkap</p>
                </div>
                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px;"></button>
            </div>
            <form id="taskForm">
                <div class="modal-body pt-3">
                    <div class="mb-4">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 shadow-sm" id="taskTitle" placeholder="Masukkan judul tugas..." required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 60px;">
                            <label for="taskTitle" class="text-muted"><i class="fas fa-tasks me-2 text-primary"></i>Judul Tugas</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-floating">
                            <textarea class="form-control border-0 shadow-sm" id="taskDescription" placeholder="Jelaskan detail tugas..." style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 120px; resize: none;"></textarea>
                            <label for="taskDescription" class="text-muted"><i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Tugas</label>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <select class="form-select border-0 shadow-sm" id="taskPriority" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 60px;">
                                    <option value="low">🟢 Rendah - Tidak mendesak</option>
                                    <option value="medium" selected>🟡 Sedang - Perlu perhatian</option>
                                    <option value="high">🔴 Tinggi - Segera dikerjakan</option>
                                </select>
                                <label for="taskPriority" class="text-muted"><i class="fas fa-flag me-2 text-primary"></i>Tingkat Prioritas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control border-0 shadow-sm" id="taskDeadline" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 60px;">
                                <label for="taskDeadline" class="text-muted"><i class="fas fa-calendar-alt me-2 text-primary"></i>Batas Waktu</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-3 rounded-3" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border: 1px dashed rgba(102, 126, 234, 0.3);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lightbulb text-warning me-3 fs-5"></i>
                            <div>
                                <small class="fw-semibold text-dark d-block">💡 Tips Produktivitas</small>
                                <small class="text-muted">Buat judul yang jelas dan tentukan deadline yang realistis untuk hasil terbaik</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2 me-2" data-bs-dismiss="modal" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                        <i class="fas fa-save me-2"></i>Simpan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;
    const priority = document.getElementById('taskPriority').value;
    const deadline = document.getElementById('taskDeadline').value;
    
    if (!title) return;
    
    const priorityConfig = {
        'low': { color: 'success', text: 'Rendah', emoji: '🟢', bg: 'rgba(25, 135, 84, 0.1)' },
        'medium': { color: 'warning', text: 'Sedang', emoji: '🟡', bg: 'rgba(255, 193, 7, 0.1)' },
        'high': { color: 'danger', text: 'Tinggi', emoji: '🔴', bg: 'rgba(220, 53, 69, 0.1)' }
    };
    
    const config = priorityConfig[priority];
    const taskId = Date.now();
    
    const taskHtml = `
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4" style="transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: ${config.bg};">
                            <span class="fs-5">${config.emoji}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown" style="width: 32px; height: 32px;">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li><a class="dropdown-item rounded-2" href="#"><i class="fas fa-edit me-2 text-primary"></i>Edit</a></li>
                                <li><a class="dropdown-item rounded-2 text-danger" href="#" onclick="this.closest('.col-lg-4').remove(); checkEmptyState();"><i class="fas fa-trash me-2"></i>Hapus</a></li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">${title}</h5>
                    <p class="text-muted mb-3 fs-6" style="line-height: 1.6;">${description || 'Tidak ada deskripsi tambahan'}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-${config.color} bg-opacity-10 text-${config.color} border border-${config.color} border-opacity-25 rounded-pill px-3 py-2">
                            ${config.text}
                        </span>
                        ${deadline ? `<small class="text-muted d-flex align-items-center"><i class="fas fa-calendar-alt me-1"></i>${new Date(deadline).toLocaleDateString('id-ID')}</small>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('taskList').insertAdjacentHTML('beforeend', taskHtml);
    document.getElementById('taskList').classList.remove('d-none');
    document.getElementById('emptyState').classList.add('d-none');
    
    // Reset form
    this.reset();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
});

function checkEmptyState() {
    const taskList = document.getElementById('taskList');
    if (taskList.children.length === 0) {
        taskList.classList.add('d-none');
        document.getElementById('emptyState').classList.remove('d-none');
    }
}
</script>
@endsection
