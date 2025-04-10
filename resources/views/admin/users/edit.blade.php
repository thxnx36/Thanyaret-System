@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="mb-6" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-user-edit text-blue-600 mr-2"></i> Edit User
    </h1>
    <p class="text-gray-600 mt-2">Edit user information and permissions</p>
</div>

<!-- Admin Navigation Menu -->
@include('admin.partials.navigation', ['active' => 'users'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                <h2 class="text-white font-bold">User Information</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <input type="text" name="name" id="name" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" id="email" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role
                        </label>
                        <select name="role" id="role" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                Regular User
                            </option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-800 transition">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Users
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="150">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-4">
                <h2 class="text-white font-bold">Additional Information</h2>
            </div>
            
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-gray-100 text-gray-700 p-2 rounded-full h-14 w-14 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="mr-2">{{ $user->email }}</span>
                        </p>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">Role:</span> 
                        <span class="px-2 py-1 rounded-full text-xs text-white 
                            {{ $user->isAdmin() ? 'bg-purple-600' : 'bg-blue-600' }}">
                            {{ $user->isAdmin() ? 'Administrator' : 'Regular User' }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">Created At:</span> 
                        {{ $user->created_at->format('d M Y, H:i') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Last Update:</span> 
                        {{ $user->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 