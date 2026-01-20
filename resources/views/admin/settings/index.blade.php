@extends('layouts.app')

@section('title', 'System Settings')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">System Settings</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <form action="{{ route('admin.settings.backup') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i> Create Backup
                </button>
            </form>
            <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-broom"></i> Clear Cache
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <!-- General Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">General Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                       id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>
                                @error('site_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                       id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Site Description</label>
                        <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                  id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
                        @error('site_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="site_logo" class="form-label">Site Logo URL</label>
                        <input type="text" class="form-control @error('site_logo') is-invalid @enderror" 
                               id="site_logo" name="site_logo" value="{{ old('site_logo', $settings['site_logo']) }}">
                        @error('site_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- System Configuration -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Configuration</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select @error('timezone') is-invalid @enderror" id="timezone" name="timezone" required>
                                    <option value="Asia/Jakarta" {{ old('timezone', $settings['timezone']) === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta</option>
                                    <option value="UTC" {{ old('timezone', $settings['timezone']) === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ old('timezone', $settings['timezone']) === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="posts_per_page" class="form-label">Items Per Page</label>
                                <input type="number" class="form-control @error('posts_per_page') is-invalid @enderror" 
                                       id="posts_per_page" name="posts_per_page" value="{{ old('posts_per_page', $settings['posts_per_page']) }}" min="1" max="50" required>
                                @error('posts_per_page')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_format" class="form-label">Date Format</label>
                                <select class="form-select @error('date_format') is-invalid @enderror" id="date_format" name="date_format" required>
                                    <option value="Y-m-d" {{ old('date_format', $settings['date_format']) === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                    <option value="d/m/Y" {{ old('date_format', $settings['date_format']) === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                    <option value="m/d/Y" {{ old('date_format', $settings['date_format']) === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                </select>
                                @error('date_format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time_format" class="form-label">Time Format</label>
                                <select class="form-select @error('time_format') is-invalid @enderror" id="time_format" name="time_format" required>
                                    <option value="H:i:s" {{ old('time_format', $settings['time_format']) === 'H:i:s' ? 'selected' : '' }}>24 Hour (HH:MM:SS)</option>
                                    <option value="h:i:s A" {{ old('time_format', $settings['time_format']) === 'h:i:s A' ? 'selected' : '' }}>12 Hour (HH:MM:SS AM/PM)</option>
                                </select>
                                @error('time_format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">File Upload Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_file_size" class="form-label">Maximum File Size</label>
                                <input type="text" class="form-control @error('max_file_size') is-invalid @enderror" 
                                       id="max_file_size" name="max_file_size" value="{{ old('max_file_size', $settings['max_file_size']) }}" required>
                                <small class="form-text text-muted">e.g., 10MB, 5GB</small>
                                @error('max_file_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="backup_frequency" class="form-label">Backup Frequency</label>
                                <select class="form-select @error('backup_frequency') is-invalid @enderror" id="backup_frequency" name="backup_frequency" required>
                                    <option value="daily" {{ old('backup_frequency', $settings['backup_frequency']) === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('backup_frequency', $settings['backup_frequency']) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('backup_frequency', $settings['backup_frequency']) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                                @error('backup_frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="allowed_file_types" class="form-label">Allowed File Types</label>
                        <input type="text" class="form-control @error('allowed_file_types') is-invalid @enderror" 
                               id="allowed_file_types" name="allowed_file_types" value="{{ old('allowed_file_types', $settings['allowed_file_types']) }}" required>
                        <small class="form-text text-muted">Comma separated, e.g., jpg,jpeg,png,pdf,doc,docx</small>
                        @error('allowed_file_types')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- System Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" 
                                   {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">
                                Maintenance Mode
                            </label>
                        </div>
                        <small class="form-text text-muted">Enable to put site in maintenance mode</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allow_registration" name="allow_registration" value="1" 
                                   {{ old('allow_registration', $settings['allow_registration']) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_registration">
                                Allow Registration
                            </label>
                        </div>
                        <small class="form-text text-muted">Allow new users to register</small>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.settings.toggle-maintenance') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-tools"></i> Toggle Maintenance
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                    <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                    <p><strong>Server:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</p>
                    <p><strong>Database:</strong> {{ config('database.default') }}</p>
                    <p><strong>Environment:</strong> 
                        <span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </p>
                    <p><strong>Debug Mode:</strong> 
                        <span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                            {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset Form
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection