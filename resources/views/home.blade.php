@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="mb-8" data-aos="fade-up">
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-red-600 to-red-900 p-8 shadow-xl">
        <div class="relative z-10">
            <h1 class="mb-4 text-3xl font-bold text-white md:text-4xl">Welcome to Thanyaret System</h1>
            <p class="mb-6 max-w-3xl text-lg text-gray-100">
                A space for exchanging ideas, creating discussion topics, and sharing knowledge within the organization
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('topics.create') }}" class="inline-flex items-center rounded bg-white px-4 py-2 font-semibold text-red-700 transition hover:bg-gray-100">
                    <i class="fas fa-plus-circle mr-2"></i> Create New Topic
                </a>
                <a href="{{ route('topics.index') }}" class="inline-flex items-center rounded border border-white bg-transparent px-4 py-2 font-semibold text-white transition hover:bg-white/10">
                    <i class="fas fa-list-alt mr-2"></i> View All Topics
                </a>
            </div>
        </div>
        
        <!-- Decorative Image -->
        <div class="absolute -bottom-10 right-0 opacity-20">
            <i class="fas fa-comments text-9xl text-white"></i>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="mb-12 grid grid-cols-1 gap-8 md:grid-cols-3" data-aos="fade-up" data-aos-delay="100">
    <div class="rounded-lg bg-white p-6 shadow-md transition hover:shadow-lg">
        <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600">
            <i class="fas fa-comments text-2xl"></i>
        </div>
        <h3 class="mb-2 text-xl font-bold text-gray-800">Exchange Ideas</h3>
        <p class="text-gray-600">
            Create discussion topics and exchange opinions with other members in the organization
        </p>
    </div>
    
    <div class="rounded-lg bg-white p-6 shadow-md transition hover:shadow-lg">
        <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-blue-600">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <h3 class="mb-2 text-xl font-bold text-gray-800">Anonymous Posting</h3>
        <p class="text-gray-600">
            Choose to post anonymously for more comfortable expression of your opinions
        </p>
    </div>
    
    <div class="rounded-lg bg-white p-6 shadow-md transition hover:shadow-lg">
        <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600">
            <i class="fas fa-th-large text-2xl"></i>
        </div>
        <h3 class="mb-2 text-xl font-bold text-gray-800">Easy Management</h3>
        <p class="text-gray-600">
            User-friendly management system for users, topics, and comments for administrators
        </p>
    </div>
</div>

<!-- Latest Topics -->
<div class="mb-10" data-aos="fade-up" data-aos-delay="150">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Latest Topics</h2>
        <a href="{{ route('topics.index') }}" class="text-red-600 hover:text-red-700 hover:underline">
            View All <i class="fas fa-chevron-right ml-1 text-xs"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @php
            $latestTopics = App\Models\Topic::with('comments')->latest()->take(3)->get();
        @endphp
        
        @forelse($latestTopics as $topic)
        <div class="rounded-lg bg-white p-6 shadow-md transition hover:shadow-lg" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
            <a href="{{ route('topics.show', $topic) }}" class="mb-3 block text-xl font-bold text-gray-800 hover:text-red-600">
                {{ $topic->title }}
            </a>
            <p class="mb-4 text-sm text-gray-600 line-clamp-2">
                @php
                    $content = $topic->content;
                    // ตรวจสอบและลบ tag <p> ออกก่อนแสดงผล
                    if (strpos($content, '<p>') === 0 && strrpos($content, '</p>') === strlen($content) - 4) {
                        $content = substr($content, 3, -4);
                    }
                @endphp
                {{ Illuminate\Support\Str::limit($content, 120) }}
            </p>
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                    <i class="far fa-user mr-1"></i> {{ $topic->getDisplayAuthorAttribute() }}
                </div>
                <div class="flex items-center">
                    <span class="mr-3">
                        <i class="far fa-calendar mr-1"></i> {{ $topic->created_at->format('d M Y') }}
                    </span>
                    <span class="flex items-center text-blue-600">
                        <i class="far fa-comment-alt mr-1"></i> {{ $topic->comments->count() }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full rounded-lg bg-white p-8 text-center shadow-md">
            <div class="mx-auto mb-4 w-20 text-gray-300">
                <i class="fas fa-comment-slash text-5xl"></i>
            </div>
            <p class="text-lg text-gray-500">No topics available yet</p>
            <a href="{{ route('topics.create') }}" class="mt-4 inline-flex items-center text-red-600 hover:text-red-700 hover:underline">
                <i class="fas fa-plus-circle mr-1"></i> Create the first topic
            </a>
        </div>
        @endforelse
    </div>
</div>

<!-- Signup Section for Guests -->
@guest
<div class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-800 p-8 shadow-xl" data-aos="fade-up" data-aos-delay="200">
    <div class="md:flex md:items-center md:justify-between">
        <div class="mb-6 md:mb-0 md:w-2/3">
            <h2 class="mb-2 text-2xl font-bold text-white">Join Us Today</h2>
            <p class="text-blue-100">
                Register now to start creating topics and sharing opinions with other members
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('register') }}" class="rounded bg-white px-6 py-3 font-semibold text-blue-700 transition hover:bg-gray-100">
                <i class="fas fa-user-plus mr-1"></i> Register
            </a>
            <a href="{{ route('login') }}" class="rounded border border-white bg-transparent px-6 py-3 font-semibold text-white transition hover:bg-white/10">
                <i class="fas fa-sign-in-alt mr-1"></i> Login
            </a>
        </div>
    </div>
</div>
@endguest
@endsection 