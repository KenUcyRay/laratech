@extends('layouts.auth')

@section('title', 'Login')
@section('subtitle', 'Masuk ke akun Anda')

@section('content')
    <div x-data="{ 
        showPassword: false, 
        username: '', 
        password: '',
        loading: false 
    }">
        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" @submit="loading = true">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="username">Username</label>
                <br>
                <input type="text" name="username" id="username" x-model="username" required autofocus
                    placeholder="Masukkan username">
                @error('username')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <br>

            <!-- Password Field -->
            <div>
                <label for="password">Password</label>
                <br>
                <div>
                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" x-model="password"
                        required placeholder="Masukkan password">
                    <button type="button" @click="showPassword = !showPassword">
                        <span x-text="showPassword ? 'Hide' : 'Show'"></span>
                    </button>
                </div>
                @error('password')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <br>

            <!-- Remember Me & Forgot Password -->
            <div>
                <label>
                    <input type="checkbox" name="remember">
                    <span>Ingat Saya</span>
                </label>
                &nbsp;
                <a href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            </div>
            <br>

            <!-- Submit Button -->
            <button type="submit" :disabled="loading">
                <span x-show="!loading">Login</span>
                <span x-show="loading">Memproses...</span>
            </button>
        </form>
    </div>
@endsection