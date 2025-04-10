@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-tachometer-alt text-blue-600 mr-2"></i> Admin Dashboard
    </h1>
    <p class="text-gray-600 mt-2">Welcome to Thanyaret System Management</p>
</div>

<!-- Admin Navigation Menu -->
@include('admin.partials.navigation', ['active' => 'dashboard'])

<!-- Summary Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6" data-aos="fade-up" data-aos-delay="100">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $users }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-users text-blue-500 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Topics</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $topics }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-comments text-green-500 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Comments</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $comments }}</p>
            </div>
            <div class="bg-amber-100 p-3 rounded-full">
                <i class="fas fa-comment-dots text-amber-500 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Popular Topics Section -->
<div class="mb-6" data-aos="fade-up" data-aos-delay="120">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-rose-600 to-rose-700 p-4 text-white">
            <h3 class="font-bold flex items-center">
                <i class="fas fa-fire mr-2"></i> Most Commented Topics
            </h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse ($popularTopics as $index => $topic)
                <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="bg-{{ ['amber', 'gray', 'bronze'][$index] ?? 'gray' }}-100 text-{{ ['amber', 'gray', 'bronze'][$index] ?? 'gray' }}-800 text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-trophy mr-1 text-{{ ['amber', 'gray', 'bronze'][$index] ?? 'gray' }}-500"></i>
                                Rank {{ $index + 1 }}
                            </div>
                            <span class="text-sm text-blue-600 flex items-center">
                                <i class="fas fa-comment-alt mr-1"></i> {{ $topic->comments_count }}
                            </span>
                        </div>
                        <a href="{{ route('topics.show', $topic) }}" class="font-medium text-lg text-blue-600 hover:text-blue-800 block mb-2 truncate">
                            {{ $topic->title }}
                        </a>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit(strip_tags($topic->content), 100) }}
                        </p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>By: {{ $topic->getDisplayAuthorAttribute() }}</span>
                            <span>{{ $topic->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-4 text-center text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i> No topics found
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="150">
    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-4 text-white">
            <h3 class="font-bold">Recent Users</h3>
        </div>
        <div class="p-4">
            <ul class="divide-y divide-gray-200">
                @forelse ($latestUsers as $user)
                <li class="py-3">
                    <div class="flex items-center">
                        <div class="bg-gray-100 text-gray-700 p-2 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">
                                <span class="mr-2">{{ $user->email }}</span>
                                <span class="bg-{{ $user->isAdmin() ? 'purple' : 'blue' }}-100 text-{{ $user->isAdmin() ? 'purple' : 'blue' }}-800 text-xs px-2 py-1 rounded-full">
                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                </span>
                            </p>
                        </div>
                        <div class="ml-auto text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                    </div>
                </li>
                @empty
                <li class="py-4 text-center text-gray-500">No users found</li>
                @endforelse
            </ul>
        </div>
    </div>
    
    <!-- Recent Topics -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 text-white">
            <h3 class="font-bold">Recent Topics</h3>
        </div>
        <div class="p-4">
            <ul class="divide-y divide-gray-200">
                @forelse ($latestTopics as $topic)
                <li class="py-3">
                    <div>
                        <a href="{{ route('topics.show', $topic) }}" class="font-medium text-blue-600 hover:text-blue-800">
                            {{ $topic->title }}
                        </a>
                        <div class="flex justify-between mt-1">
                            <span class="text-sm text-gray-500">
                                By: {{ $topic->getDisplayAuthorAttribute() }}
                            </span>
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-comment-alt mr-1 text-blue-500"></i> {{ $topic->comments->count() }}
                            </span>
                        </div>
                    </div>
                </li>
                @empty
                <li class="py-4 text-center text-gray-500">No topics found</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection 