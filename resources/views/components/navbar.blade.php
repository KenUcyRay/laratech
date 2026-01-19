<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-tools me-2"></i>LaraTech
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Admin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('operator.dashboard') }}">
                        <i class="fas fa-desktop me-1"></i>Operator
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mekanik.dashboard') }}">
                        <i class="fas fa-wrench me-1"></i>Mekanik
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>