@extends('layouts.app')

@section('title', 'Manage Comments')

@section('content')
<div class="mb-6" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-comment-dots text-amber-600 mr-2"></i> Manage Comments
    </h1>
    <p class="text-gray-600 mt-2">Manage all comments in the system</p>
</div>

<!-- Admin Navigation Menu -->
@include('admin.partials.navigation', ['active' => 'comments'])

<div class="bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="bg-gradient-to-r from-amber-600 to-amber-700 p-4">
        <div class="flex justify-between items-center">
            <h2 class="text-white font-bold">All Comments</h2>
            <div class="text-white">
                <span class="bg-amber-800 px-3 py-1 rounded-full text-sm">
                    Total: {{ $comments->total() }} comments
                </span>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Comment</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Author</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Related Topic</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Created At</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($comments as $comment)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="text-gray-700 line-clamp-2">{{ $comment->content }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($comment->is_anonymous)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-user-secret mr-1"></i> Anonymous
                            </span>
                        @else
                            <span class="text-gray-700">{{ $comment->author_name }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.topics.show', $comment->topic) }}" 
                           class="text-blue-600 hover:text-blue-800 transition">
                            {{ \Illuminate\Support\Str::limit($comment->topic->title, 30) }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $comment->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.topics.show', $comment->topic) }}" 
                               class="text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-eye"></i> View Topic
                            </a>
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this comment?')" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <img src="{{ asset('images/empty-comments.svg') }}" alt="No comments" class="w-40 mb-4">
                            <p>No comments found in the system</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t">
        {{ $comments->links() }}
    </div>
</div>
@endsection 