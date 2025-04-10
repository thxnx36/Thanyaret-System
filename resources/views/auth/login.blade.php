@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex justify-center mt-4" data-aos="fade-up">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-700 to-red-900 p-6 text-white">
                <h2 class="text-2xl font-bold text-center">Login</h2>
                <p class="text-center mt-2 text-gray-100">Welcome back!</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="p-6">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-envelope text-gray-600 mr-1"></i>
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 @error('email') border-red-500 @enderror"
                           placeholder="Enter your email">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-lock text-gray-600 mr-1"></i>
                        Password
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 @error('password') border-red-500 @enderror"
                           placeholder="Enter your password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="remember" class="ml-2 text-gray-700">Remember me</label>
                    </div>
                </div>
                
                <div class="flex flex-col space-y-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 btn-hover flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                    
                    <div class="text-center text-gray-600 mt-4">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            Register now
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 