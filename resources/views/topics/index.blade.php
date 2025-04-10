@extends('layouts.app')

@section('title', 'Topic List')

@section('content')
<div class="mb-6" data-aos="fade-up">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Discussion Topics</h1>
        
        <div class="flex flex-col md:flex-row gap-3">
            <a href="{{ route('topics.create') }}" class="btn-hover inline-flex items-center justify-center bg-red-800 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-300">
                <i class="fas fa-plus-circle mr-2"></i> Create New Topic
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden card-hover" data-aos="fade-up" data-aos-delay="100">
    <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="font-medium text-gray-700">
            All Topics
            @if(request('sort'))
                @php
                    $sortLabel = '';
                    switch(request('sort')) {
                        case 'most_comments':
                            $sortLabel = 'Most Comments';
                            break;
                        case 'oldest':
                            $sortLabel = 'Oldest First';
                            break;
                        case 'newest_comment':
                            $sortLabel = 'Recent Activity';
                            break;
                        default:
                            $sortLabel = 'Latest First';
                    }
                @endphp
                <span class="ml-2 text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded">
                    <i class="fas fa-sort mr-1"></i> {{ $sortLabel }}
                </span>
            @endif
        </h3>
        
        <!-- Filter options -->
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Sort by:</span>
            <select id="topicSort" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300" onchange="window.location.href=this.value">
                <option value="{{ route('topics.index', ['sort' => 'latest']) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                <option value="{{ route('topics.index', ['sort' => 'oldest']) }}" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </div>
    </div>
    
    <!-- Search Results -->
    @if(request('search'))
    <div class="bg-blue-50 p-3 border-b border-blue-100">
        <div class="flex items-center text-blue-800">
            <i class="fas fa-search mr-2"></i>
            <p>Search results for: <span class="font-semibold">"{{ request('search') }}"</span></p>
            <a href="{{ route('topics.index') }}" class="ml-3 text-sm text-red-600 hover:text-red-800">
                <i class="fas fa-times-circle"></i> Clear Search
            </a>
        </div>
    </div>
    @endif

    <div class="overflow-x-auto">
        @if(request('sort') == 'most_comments' && auth()->check() && auth()->user()->isAdmin())
            <div class="bg-yellow-50 p-3 text-sm border-b border-yellow-200">
                <p class="text-yellow-800"><i class="fas fa-info-circle mr-1"></i> Debug mode: Showing topics sorted by comment count (desc)</p>
            </div>
        @endif
        
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-4 px-6 text-left text-gray-700 font-semibold">Topic</th>
                    <th class="py-4 px-6 text-center text-gray-700 font-semibold">
                        Comments
                        @if(request('sort') == 'most_comments')
                            <i class="fas fa-arrow-down ml-1 text-red-600"></i>
                        @endif
                    </th>
                    <th class="py-4 px-6 text-center text-gray-700 font-semibold">Latest Comment</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($topics as $topic)
                <tr class="hover:bg-gray-50 transition-colors duration-150 {{ request('sort') == 'most_comments' ? 'hover:bg-yellow-50' : '' }}">
                    <td class="py-4 px-6">
                        <a href="{{ route('topics.show', $topic) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-all duration-200">
                            {{ $topic->title }}
                        </a>
                        <p class="text-gray-500 text-sm mt-1">By: {{ $topic->getDisplayAuthorAttribute() }} • {{ $topic->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($topic->comments_count > 0)
                            @php
                                $bgColor = 'bg-blue-100';
                                $textColor = 'text-blue-800';
                                
                                if($topic->comments_count >= 20) {
                                    $bgColor = 'bg-red-100';
                                    $textColor = 'text-red-800';
                                } elseif($topic->comments_count >= 10) {
                                    $bgColor = 'bg-purple-100';
                                    $textColor = 'text-purple-800';
                                } elseif($topic->comments_count >= 5) {
                                    $bgColor = 'bg-green-100';
                                    $textColor = 'text-green-800';
                                }
                            @endphp
                            <span class="inline-flex items-center justify-center {{ $bgColor }} {{ $textColor }} px-3 py-1 rounded-full font-medium">
                                {{ $topic->comments_count }}
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">
                                0
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if ($topic->comments_count > 0)
                            @php
                                $latestComment = $topic->comments->first();
                            @endphp
                            <div class="text-sm text-gray-600">
                                {{ $latestComment->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="text-blue-600 font-medium mt-1">
                                {{ $latestComment->getDisplayAuthorAttribute() }}
                            </div>
                        @else
                            <div class="text-gray-500 italic">No comments yet</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-comment-slash text-4xl mb-3 text-gray-400"></i>
                            @if(request('search'))
                                <p class="text-lg">No topics found matching "{{ request('search') }}"</p>
                                <a href="{{ route('topics.index') }}" class="mt-3 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-arrow-left mr-1"></i> Back to all topics
                                </a>
                            @else
                                <p class="text-lg">No topics available yet</p>
                                <p class="mt-2">You can be the first to create a new topic!</p>
                                <a href="{{ route('topics.create') }}" class="mt-4 inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="fas fa-plus-circle mr-2"></i> Create New Topic
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(method_exists($topics, 'links') && $topics->hasPages())
<div class="mt-6" data-aos="fade-up" data-aos-delay="200">
    {{ $topics->withQueryString()->links() }}
</div>
@endif
@endsection 