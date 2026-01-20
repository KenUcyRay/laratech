<nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid px-4">
        <div class="navbar-brand d-flex align-items-center text-white text-decoration-none">
            <img src="{{ asset('img/logo2.png') }}" alt="LaraTech Logo" 
                 class="rounded-circle border border-white border-2 me-3" 
                 style="width: 40px; height: 40px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            <span class="fw-bold fs-4">LaraTech</span>
        </div>

        @auth
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn text-white d-flex align-items-center px-4 py-2 rounded-pill border border-white border-opacity-25"
                    style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); transition: all 0.3s ease;"
                    onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.borderColor='rgba(255,255,255,0.5)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.15)'; this.style.borderColor='rgba(255,255,255,0.25)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span class="fw-medium">Logout</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </div>
</nav>
