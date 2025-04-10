@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="mb-6" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-users text-blue-600 mr-2"></i> Manage Users
    </h1>
    <p class="text-gray-600 mt-2">Manage all users in the system</p>
</div>

<!-- Admin Navigation Menu -->
@include('admin.partials.navigation', ['active' => 'users'])

<div class="bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
        <div class="flex justify-between items-center">
            <h2 class="text-white font-bold">All Users</h2>
            <div class="text-white">
                <span class="bg-blue-800 px-3 py-1 rounded-full text-sm">
                    Total: {{ $users->total() }} users
                </span>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Created At</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="bg-gray-100 text-gray-700 p-2 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-sm text-white 
                            {{ $user->isAdmin() ? 'bg-purple-600' : 'bg-blue-600' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                                class="text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            @if (auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this user?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400 cursor-not-allowed">
                                <i class="fas fa-trash-alt"></i> Delete
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <img src="{{ asset('images/empty.svg') }}" alt="No users" class="w-40 mb-4">
                            <p>No users found in the system</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection 