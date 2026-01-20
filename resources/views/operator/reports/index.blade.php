@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-exclamation-triangle" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="fas fa-bug text-white fs-4"></i>
                        </div>
                        <h1 class="fw-bold mb-0 text-white">Laporan Kerusakan</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🚨 Laporkan kerusakan equipment dengan detail dan foto
                    </p>
                </div>
                <button class="btn btn-light rounded-pill px-4 py-3 shadow" data-bs-toggle="modal" data-bs-target="#reportModal" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-plus me-2 text-primary"></i>
                    <span class="fw-semibold text-dark">Buat Laporan</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Reports List --}}
    <div class="row g-4" id="reportsList">
        {{-- Reports will be added here dynamically --}}
    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
            <i class="fas fa-clipboard-list fa-3x text-muted"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Belum ada laporan</h4>
        <p class="text-muted mb-4 fs-6">
            Buat laporan kerusakan equipment jika ditemukan masalah
        </p>
        <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-plus me-2"></i>Buat Laporan Pertama
        </button>
    </div>

</div>

{{-- Report Modal --}}
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <div class="text-center w-100">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3 text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">🚨 Laporan Kerusakan</h3>
                    <p class="text-muted mb-0 fs-6">Laporkan kerusakan equipment dengan detail lengkap</p>
                </div>
                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px;"></button>
            </div>
            <form id="reportForm">
                <div class="modal-body pt-3">
                    <div class="mb-4">
                        <div class="form-floating">
                            <textarea class="form-control border-0 shadow-sm" id="description" placeholder="Jelaskan kerusakan yang ditemukan..." required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 120px; resize: none;"></textarea>
                            <label for="description" class="text-muted"><i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Kerusakan</label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-floating">
                            <select class="form-select border-0 shadow-sm" id="severity" required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; height: 60px;">
                                <option value="">Pilih tingkat keparahan...</option>
                                <option value="low">🟢 Low - Tidak mengganggu operasi</option>
                                <option value="medium">🟡 Medium - Perlu perhatian</option>
                                <option value="high">🔴 High - Mengganggu operasi</option>
                            </select>
                            <label for="severity" class="text-muted"><i class="fas fa-exclamation-circle me-2 text-primary"></i>Tingkat Keparahan</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold"><i class="fas fa-camera me-2 text-primary"></i>Upload Foto Kerusakan</label>
                        <div class="border-2 border-dashed rounded-4 p-4 text-center" style="border-color: #dee2e6; background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);">
                            <input type="file" class="form-control d-none" id="photo" accept="image/*" multiple>
                            <div id="uploadArea" onclick="document.getElementById('photo').click()" style="cursor: pointer;">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <h6 class="fw-bold text-dark mb-2">Klik untuk upload foto</h6>
                                <p class="text-muted mb-0 small">Drag & drop atau klik untuk memilih foto kerusakan</p>
                            </div>
                            <div id="photoPreview" class="mt-3 d-none">
                                <div class="row g-2" id="previewContainer"></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(29, 78, 216, 0.1) 100%); border: 1px dashed rgba(59, 130, 246, 0.3);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-3 fs-5"></i>
                            <div>
                                <small class="fw-semibold text-dark d-block">📝 Tips Pelaporan</small>
                                <small class="text-muted">Sertakan foto yang jelas dan deskripsi detail untuk mempercepat penanganan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2 me-2" data-bs-dismiss="modal" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let reportData = [];
let reportCounter = 0;

// Photo upload preview
document.getElementById('photo').addEventListener('change', function(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('previewContainer');
    const photoPreview = document.getElementById('photoPreview');
    
    if (files.length > 0) {
        previewContainer.innerHTML = '';
        photoPreview.classList.remove('d-none');
        
        Array.from(files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML += `
                    <div class="col-md-4">
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded-3" style="height: 100px; width: 100%; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute" style="top: 5px; right: 5px; width: 25px; height: 25px; padding: 0;" onclick="this.closest('.col-md-4').remove()">
                                <i class="fas fa-times" style="font-size: 10px;"></i>
                            </button>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        });
    }
});

// Form submission
document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const description = document.getElementById('description').value;
    const severity = document.getElementById('severity').value;
    const photos = document.getElementById('photo').files;
    
    if (!description || !severity) {
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return;
    }
    
    const severityConfig = {
        'low': { color: 'success', emoji: '🟢', text: 'Low' },
        'medium': { color: 'warning', emoji: '🟡', text: 'Medium' },
        'high': { color: 'danger', emoji: '🔴', text: 'High' }
    };
    
    const config = severityConfig[severity];
    reportCounter++;
    const reportId = reportCounter;
    const now = new Date();
    
    // Store report data with photos
    const photoUrls = [];
    if (photos.length > 0) {
        Array.from(photos).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoUrls.push(e.target.result);
            };
            reader.readAsDataURL(file);
        });
    }
    
    const report = {
        id: reportId,
        description: description,
        severity: severity,
        photoCount: photos.length,
        photos: photoUrls,
        timestamp: now
    };
    reportData.push(report);
    
    const reportHtml = `
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4" style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''" onclick="showReportDetail(${reportId})">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(59,130,246,0.1);">
                            <span class="fs-5">📋</span>
                        </div>
                        <span class="badge bg-${config.color} bg-opacity-10 text-${config.color} border border-${config.color} border-opacity-25 rounded-pill px-3 py-2">
                            ${config.emoji} ${config.text}
                        </span>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Laporan #${reportId}</h6>
                    <p class="text-muted mb-3 fs-6" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${description}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>${now.toLocaleDateString('id-ID')} ${now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                        </small>
                        ${photos.length > 0 ? `<small class="text-success"><i class="fas fa-camera me-1"></i>${photos.length} foto</small>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('reportsList').insertAdjacentHTML('beforeend', reportHtml);
    document.getElementById('emptyState').classList.add('d-none');
    
    // Reset form
    this.reset();
    document.getElementById('photoPreview').classList.add('d-none');
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
    
    alert('Laporan berhasil dikirim!');
});

// Show report detail modal
function showReportDetail(reportId) {
    const report = reportData.find(r => r.id == reportId);
    if (!report) return;
    
    const severityConfig = {
        'low': { color: 'success', emoji: '🟢', text: 'Low' },
        'medium': { color: 'warning', emoji: '🟡', text: 'Medium' },
        'high': { color: 'danger', emoji: '🔴', text: 'High' }
    };
    
    const config = severityConfig[report.severity];
    
    const detailModalHtml = `
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <div class="text-center w-100">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-eye fs-3 text-primary"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Detail Laporan #${reportId}</h4>
                        </div>
                        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px;"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div class="mb-3">
                            <label class="fw-semibold text-muted mb-2">Tingkat Keparahan:</label>
                            <div>
                                <span class="badge bg-${config.color} bg-opacity-10 text-${config.color} border border-${config.color} border-opacity-25 rounded-pill px-3 py-2">
                                    ${config.emoji} ${config.text}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted mb-2">Deskripsi Kerusakan:</label>
                            <p class="text-dark">${report.description}</p>
                        </div>
                        ${report.photoCount > 0 ? `
                        <div class="mb-3">
                            <label class="fw-semibold text-muted mb-2">Foto Kerusakan:</label>
                            <div class="row g-2">
                                ${report.photos.map((photo, index) => `
                                    <div class="col-md-4">
                                        <img src="${photo}" class="img-fluid rounded-3" style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;" onclick="openPhotoModal('${photo}', ${index + 1})">
                                    </div>
                                `).join('')}
                            </div>
                            <small class="text-muted">Klik foto untuk memperbesar</small>
                        </div>
                        ` : ''}
                        <div class="mb-3">
                            <label class="fw-semibold text-muted mb-2">Waktu Laporan:</label>
                            <p class="text-dark">${report.timestamp.toLocaleDateString('id-ID')} ${report.timestamp.toLocaleTimeString('id-ID')}</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing detail modal if any
    const existingModal = document.getElementById('detailModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add new modal to body
    document.body.insertAdjacentHTML('beforeend', detailModalHtml);
    
    // Show modal
    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    detailModal.show();
    
    // Remove modal from DOM when hidden
    document.getElementById('detailModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Open photo in modal
function openPhotoModal(photoSrc, photoIndex) {
    const photoModalHtml = `
        <div class="modal fade" id="photoModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <div class="text-center w-100">
                            <h5 class="fw-bold text-dark mb-0">Foto Kerusakan #${photoIndex}</h5>
                        </div>
                        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px;"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <img src="${photoSrc}" class="img-fluid rounded-4" style="max-height: 500px; width: auto;">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const existingPhotoModal = document.getElementById('photoModal');
    if (existingPhotoModal) {
        existingPhotoModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', photoModalHtml);
    
    const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
    photoModal.show();
    
    document.getElementById('photoModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}
</script>
@endsection