@extends('layouts.app')

@section('title', 'Topic Details')

@section('content')
<div class="mb-6 flex justify-between items-center" data-aos="fade-up">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-file-alt text-green-600 mr-2"></i> Topic Details
        </h1>
        <p class="text-gray-600 mt-2">View topic details and all comments</p>
    </div>
    <a href="{{ route('admin.topics') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition">
        <i class="fas fa-arrow-left mr-1"></i> Back to Topics
    </a>
</div>

<!-- Admin Navigation Menu -->
@include('admin.partials.navigation', ['active' => 'topics'])

<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    <!-- Topic Details -->
    <div class="md:col-span-12" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-white font-bold">Topic Details</h2>
                    <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this topic? All comments will be deleted too.')" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                            <i class="fas fa-trash-alt mr-1"></i> Delete Topic
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $topic->title }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span class="mr-4">
                            <i class="far fa-user mr-1"></i>
                            @if ($topic->is_anonymous)
                                <span class="italic">Anonymous</span>
                            @else
                                {{ $topic->author_name }}
                            @endif
                        </span>
                        <span class="mr-4">
                            <i class="far fa-calendar-alt mr-1"></i> 
                            {{ $topic->created_at->format('d M Y, H:i') }}
                        </span>
                        <span>
                            <i class="far fa-comment-alt mr-1"></i> 
                            {{ $topic->comments->count() }} comments
                        </span>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $topic->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- All Comments -->
    <div class="md:col-span-12" data-aos="fade-up" data-aos-delay="150">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                <h2 class="text-white font-bold">All Comments ({{ $topic->comments->count() }})</h2>
            </div>
            
            <div class="p-6">
                @forelse ($topic->comments->sortByDesc('created_at') as $comment)
                <div class="bg-gray-50 rounded-lg p-4 mb-4 hover:shadow-md transition" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="flex justify-between">
                        <div class="flex items-center mb-2">
                            <div class="bg-blue-100 text-blue-700 p-2 rounded-full h-8 w-8 flex items-center justify-center mr-2">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <p class="font-medium">
                                    @if ($comment->is_anonymous)
                                        <span class="italic text-gray-700">Anonymous</span>
                                    @else
                                        {{ $comment->author_name }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $comment->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this comment?')" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="pl-10">
                        <p class="text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <img src="{{ asset('images/empty-comments.svg') }}" alt="No comments" class="w-40 mx-auto mb-4">
                    <p>No comments for this topic yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 