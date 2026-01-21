<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LaraTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .login-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
    </style>
</head>
<body class="login-container min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-6xl w-full flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <img src="{{ asset('img/loginmecha.jpg') }}" alt="Mechanic" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
            <div class="absolute top-8 left-8">
                <img src="{{ asset('img/logo2.png') }}" alt="LaraTech Logo" class="w-24 h-24 object-cover rounded-full shadow-xl border-4 border-white">
            </div>
            <div class="absolute bottom-10 left-10 right-10 text-white">
                <div class="bg-black/30 backdrop-blur-sm rounded-2xl p-8">
                    <h2 class="text-4xl font-bold mb-6">Pengelola Secara Efisien</h2>
                    <p class="text-xl leading-relaxed">
                      Lacak jadwal perawatan, status peralatan, dan penugasan teknisi dengan mudah dalam satu tempat.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 p-12 lg:p-20 flex flex-col justify-center">
            <div class="mb-12">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Welcome To LaraTech!</h1>
                <p class="text-xl text-gray-600">Masukan Akun Anda</p>
            </div>

            <div x-data="{ 
                showPassword: false, 
                username: '', 
                password: '',
                loading: false 
            }">
                <form action="{{ route('login') }}" method="POST" @submit="loading = true" class="space-y-8">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-lg font-medium text-gray-700 mb-3">Username</label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               x-model="username" 
                               required 
                               autofocus
                               placeholder="Masukan Username"
                               class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('username')
                            <div class="text-red-500 text-base mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-lg font-medium text-gray-700 mb-3">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   id="password" 
                                   x-model="password"
                                   required 
                                   placeholder="••••••••"
                                   class="w-full px-6 py-4 pr-14 text-lg border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg x-show="!showPassword" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-red-500 text-base mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            :disabled="loading"
                            class="w-full bg-gradient-to-r from-blue-800 to-cyan-500 hover:from-blue-900 hover:to-cyan-600 disabled:opacity-50 text-white font-medium py-4 px-6 text-lg rounded-xl transition-all">
                        <span x-show="!loading">Sign In</span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>