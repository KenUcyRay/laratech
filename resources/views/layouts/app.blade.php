<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'LaraTech') }} - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body>
    <div id="app">
        @if(request()->is('operator/*'))
            <div class="sticky-top">
                @include('components.operator-navbar')
            </div>
        @elseif(request()->is('manager/*'))
            <div class="sticky-top">
                @include('components.manager-navbar')
            </div>
        @elseif(request()->is('mekanik/*'))
            <div class="sticky-top">
                @include('components.mekanik-navbar')
            </div>
        @else
            <div class="sticky-top">
                @include('components.navbar')
            </div>
        @endif
        
        <div class="container-fluid p-0">
            <div class="row g-0">
                @hasSection('sidebar')
                    <nav class="col-md-3 col-lg-2 d-md-block p-0 sidebar position-fixed" style="top: 0; height: 100vh; z-index: 1000;">
                        @yield('sidebar')
                    </nav>
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">
                        @yield('content')
                    </main>
                @else
                    <main class="col-12">
                        @yield('content')
                    </main>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>