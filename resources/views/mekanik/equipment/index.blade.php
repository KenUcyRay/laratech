@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tools" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Equipment Inventory</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            🚜 Kelola dan monitor status semua equipment
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipment Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($equipments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="fw-semibold" width="15%">Code</th>
                                    <th class="fw-semibold" width="25%">Name</th>
                                    <th class="fw-semibold" width="20%">Type</th>
                                    <th class="fw-semibold" width="20%">Current Status</th>
                                    <th class="fw-semibold" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipments as $eq)
                                    <tr id="row-{{ $eq->id }}">
                                        <td><span class="badge bg-secondary">{{ $eq->code }}</span></td>
                                        <td><strong>{{ $eq->name }}</strong></td>
                                        <td>{{ $eq->type->name ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }}">
                                                {{ ucfirst($eq->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white update-status-btn"
                                                data-id="{{ $eq->id }}" data-status="{{ $eq->status }}" data-name="{{ $eq->name }}">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{ $equipments->links('custom.mekanik-pagination') }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tools fa-4x text-muted mb-4 opacity-50"></i>
                        <h5 class="text-muted fw-semibold">No Equipment Found</h5>
                        <p class="text-muted mb-0">There are currently no equipment items to display.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Status Update Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="statusForm">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 pb-2"
                        style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
                        <h5 class="modal-title fw-bold text-white">Update Status: <span id="eqName"></span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-3 px-4">
                        <input type="hidden" name="id" id="eqId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Status</label>
                            <select name="status" class="form-select form-select-lg" required>
                                <option value="idle">🟡 Idle</option>
                                <option value="operasi">🟢 Operasi</option>
                                <option value="rusak">🔴 Rusak</option>
                                <option value="servis">🟠 Servis</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white fw-bold"
                            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom Popup Styles - Mekanik Theme */
            .custom-popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 9998;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 0.2s ease;
            }

            .custom-popup {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                max-width: 400px;
                width: 90%;
                animation: slideDown 0.3s ease;
                overflow: hidden;
            }

            .custom-popup-header {
                background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);
                color: white;
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .custom-popup-header i {
                font-size: 2rem;
            }

            .custom-popup-body {
                padding: 1.5rem;
            }

            .custom-popup-title {
                font-size: 1.25rem;
                font-weight: bold;
                margin: 0;
            }

            .custom-popup-text {
                color: #6c757d;
                margin: 0;
            }

            .custom-popup-buttons {
                display: flex;
                gap: 0.5rem;
                margin-top: 1.5rem;
            }

            .custom-popup-btn {
                flex: 1;
                padding: 0.75rem;
                border: none;
                border-radius: 0.5rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }

            .custom-popup-btn-primary {
                background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);
                color: white;
            }

            .custom-popup-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(182, 119, 29, 0.4);
            }

            .custom-popup-btn-secondary {
                background: #e9ecef;
                color: #495057;
            }

            .custom-popup-btn-secondary:hover {
                background: #dee2e6;
            }

            /* Toast Notification */
            .custom-toast {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 0.75rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                padding: 1rem 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                z-index: 9999;
                animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s;
                min-width: 300px;
            }

            .custom-toast.success {
                border-left: 4px solid #10B981;
            }

            .custom-toast.error {
                border-left: 4px solid #EF4444;
            }

            .custom-toast i {
                font-size: 1.5rem;
            }

            .custom-toast.success i {
                color: #10B981;
            }

            .custom-toast.error i {
                color: #EF4444;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeOut {
                to {
                    opacity: 0;
                    transform: translateX(100px);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Custom Popup Functions
            function showToast(type, title) {
                const toast = document.createElement('div');
                toast.className = `custom-toast ${type}`;
                toast.innerHTML = `
                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                            <div>
                                <strong>${title}</strong>
                            </div>
                        `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            function showAlert(type, title, text, callback) {
                const overlay = document.createElement('div');
                overlay.className = 'custom-popup-overlay';
                overlay.innerHTML = `
                            <div class="custom-popup">
                                <div class="custom-popup-header">
                                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                                    <div>
                                        <h5 class="custom-popup-title">${title}</h5>
                                    </div>
                                </div>
                                <div class="custom-popup-body">
                                    <p class="custom-popup-text">${text}</p>
                                    <div class="custom-popup-buttons">
                                        <button class="custom-popup-btn custom-popup-btn-primary" onclick="this.closest('.custom-popup-overlay').remove(); ${callback ? callback + '()' : ''}">OK</button>
                                    </div>
                                </div>
                            </div>
                        `;
                document.body.appendChild(overlay);
            }

            document.querySelectorAll('.update-status-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    let name = this.dataset.name;
                    let currentStatus = this.dataset.status;

                    document.getElementById('eqId').value = id;
                    document.getElementById('eqName').innerText = name;
                    document.querySelector(`select[name="status"]`).value = currentStatus;

                    new bootstrap.Modal(document.getElementById('statusModal')).show();
                });
            });

            document.getElementById('statusForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let id = document.getElementById('eqId').value;
                let status = document.querySelector(`select[name="status"]`).value;

                fetch(`/mekanik/inventory/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        status: status
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();

                        if (data.status === 'success') {
                            showToast('success', 'Status berhasil diperbarui');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert('error', 'Error', data.message);
                        }
                    });
            });
        </script>
    @endpush
@endsection