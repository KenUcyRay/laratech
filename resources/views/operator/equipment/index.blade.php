@extends('layouts.app')

@section('title', 'Equipment')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-cogs" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Equipment Monitoring</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        ⚙️ Monitoring pemakaian dan status equipment
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Equipment Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">No</th>
                            <th class="fw-semibold">Kode</th>
                            <th class="fw-semibold">Equipment</th>
                            <th class="fw-semibold">Tipe</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Hour Meter</th>
                            <th class="fw-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipments ?? [] as $index => $equipment)
                            <tr>
                                <td class="fw-medium">{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $equipment->code }}</td>
                                <td>{{ $equipment->name }}</td>
                                <td>{{ $equipment->type->name ?? '-' }}</td>
                                <td>
                                    @if($equipment->status === 'operasi')
                                        <span class="badge bg-success">Operasi</span>
                                    @elseif($equipment->status === 'servis')
                                        <span class="badge bg-warning">Servis</span>
                                    @elseif($equipment->status === 'rusak')
                                        <span class="badge bg-danger">Rusak</span>
                                    @else
                                        <span class="badge bg-secondary">Idle</span>
                                    @endif
                                </td>
                                <td>{{ number_format($equipment->hour_meter) }} jam</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#reportModal" onclick="setEquipmentForReport('{{ $equipment->code }}', '{{ $equipment->name }}')">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Buat Laporan
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-cogs fs-3 mb-2"></i>
                                        <p class="mb-0">Tidak ada equipment tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Report Modal from reports/index --}}
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
                            <input type="text" class="form-control border-0 shadow-sm" id="equipmentInfo" readonly style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                            <label for="equipmentInfo" class="text-muted"><i class="fas fa-cogs me-2 text-primary"></i>Equipment</label>
                        </div>
                    </div>
                    
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
                </div>
                <div class="modal-footer border-0 pt-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2 me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let reportData = JSON.parse(localStorage.getItem('reportData')) || [];
let reportCounter = parseInt(localStorage.getItem('reportCounter')) || 0;

// Set equipment info for report
function setEquipmentForReport(code, name) {
    document.getElementById('equipmentInfo').value = `${code} - ${name}`;
}

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
    
    const equipmentInfo = document.getElementById('equipmentInfo').value;
    const description = document.getElementById('description').value;
    const severity = document.getElementById('severity').value;
    const photos = document.getElementById('photo').files;
    
    if (!equipmentInfo || !description || !severity) {
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return;
    }
    
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
        equipment: equipmentInfo,
        description: description,
        severity: severity,
        photoCount: photos.length,
        photos: photoUrls,
        timestamp: now
    };
    reportData.push(report);
    
    // Save to localStorage
    localStorage.setItem('reportData', JSON.stringify(reportData));
    localStorage.setItem('reportCounter', reportCounter.toString());
    
    // Reset form
    this.reset();
    document.getElementById('photoPreview').classList.add('d-none');
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
    
    alert('Laporan berhasil dikirim! Data tersimpan di menu Reports.');
});
</script>
@endsection