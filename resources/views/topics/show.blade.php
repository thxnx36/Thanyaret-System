@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<div class="mb-5" data-aos="fade-right">
    <a href="{{ route('topics.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i> Back to Topic List
    </a>
</div>

<!-- Topic Details -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6 card-hover" data-aos="fade-up">
    <div class="flex justify-between items-start mb-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $topic->title }}</h1>
        
        <!-- Share and Download buttons -->
        <div class="flex space-x-2 ml-4">
            <div class="relative" id="shareDropdown">
                <button class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition-colors duration-200" title="Share this topic">
                    <i class="fas fa-share-alt"></i>
                </button>
                <!-- Share menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10 hidden" id="shareMenu">
                    <a href="#" onclick="shareViaFacebook(); return false;" class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                        <i class="fab fa-facebook-f mr-3 text-blue-600"></i> Facebook
                    </a>
                    <a href="#" onclick="shareViaTwitter(); return false;" class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                        <i class="fab fa-twitter mr-3 text-blue-400"></i> Twitter
                    </a>
                    <a href="#" onclick="shareViaLine(); return false;" class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                        <i class="fab fa-line mr-3 text-green-600"></i> Line
                    </a>
                    <a href="#" onclick="copyLink(); return false;" class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                        <i class="fas fa-link mr-3 text-gray-600"></i> Copy Link
                    </a>
                </div>
            </div>
            
            <a href="#" onclick="generatePDF(); return false;" class="bg-green-100 text-green-600 p-2 rounded-lg hover:bg-green-200 transition-colors duration-200" title="Save as PDF">
                <i class="fas fa-file-pdf"></i>
            </a>
            
            <a href="{{ route('topics.edit', $topic) }}" class="bg-amber-100 text-amber-600 p-2 rounded-lg hover:bg-amber-200 transition-colors duration-200" title="Edit this topic">
                <i class="fas fa-edit"></i>
            </a>
        </div>
    </div>
    
    <div class="border-b border-gray-200 pb-4 mb-4">
        <div class="flex items-center text-gray-600 mb-2">
            <div class="flex items-center">
                <div class="bg-blue-100 text-blue-800 p-2 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                    <i class="fas {{ $topic->is_anonymous ? 'fa-user-secret' : 'fa-user' }}"></i>
                </div>
                <div>
                    <span class="font-medium">{{ $topic->getDisplayAuthorAttribute() }}</span>
                    <div class="text-sm text-gray-500">
                        <i class="far fa-clock mr-1"></i> {{ $topic->created_at->locale('th')->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="prose max-w-none text-gray-700 leading-relaxed">
        @if(trim($topic->content) !== '')
            {!! Str::of(nl2br(e($topic->content)))->replace('<p>', '')->replace('</p>', '') !!}
        @else
            <p class="text-gray-500 italic">No additional content</p>
        @endif
    </div>
</div>

<!-- Comments -->
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-comments text-blue-600 mr-2"></i>
            Comments 
            <span class="ml-2 bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm">
                {{ $topic->comments_count }}
            </span>
        </h2>
        
        <!-- Comment sorting options -->
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Sort by:</span>
            <select id="commentSort" class="text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
    </div>
    
    <div class="space-y-4" id="commentsContainer">
        @forelse ($topic->comments->sortByDesc('created_at') as $comment)
        <div class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-center border-b border-gray-100 pb-3 mb-3">
                <div class="bg-gray-100 text-gray-700 p-2 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                    <i class="fas {{ $comment->is_anonymous ? 'fa-user-secret' : 'fa-user' }}"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-800">{{ $comment->getDisplayAuthorAttribute() }}</div>
                    <div class="text-xs text-gray-500">{{ $comment->created_at->locale('th')->format('d M Y, H:i') }}</div>
                </div>
            </div>
            
            <div class="text-gray-700 leading-relaxed">
                {!! nl2br(e($comment->content)) !!}
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <img src="https://illustrations.popsy.co/gray/discussion.svg" alt="No Comments" class="w-48 h-48 mx-auto mb-4">
            <p class="text-gray-500 text-lg">No comments for this topic yet</p>
            <p class="text-gray-600 mt-2">You can be the first to comment!</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Comment Form -->
<div class="bg-white rounded-lg shadow-lg p-6 card-hover">
    <div class="flex items-center mb-5">
        <div class="bg-green-600 rounded-full p-2 text-white mr-3">
            <i class="fas fa-comment-dots text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">Add a Comment</h2>
    </div>
    
    <form action="{{ route('comments.store', $topic) }}" method="POST" id="commentForm">
        @csrf
        
        <div class="mb-5">
            <label for="content" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-comment text-gray-600 mr-1"></i>
                Your Comment <span class="text-red-600">*</span>
            </label>
            <textarea name="content" id="content" rows="4" 
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('content') border-red-500 @enderror"
                      required placeholder="Share your thoughts here...">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
        
        <div class="mb-5">
            <label for="author_name" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-user text-gray-600 mr-1"></i>
                Your Name
            </label>
            @auth
                <input type="text" name="author_name" id="author_name" value="{{ old('author_name', Auth::user()->name) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('author_name') border-red-500 @enderror"
                       placeholder="Your name" readonly>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i> Your username will be used automatically unless you choose to post anonymously
                </p>
            @else
                <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('author_name') border-red-500 @enderror"
                       placeholder="Your name (if not specified, will be shown as anonymous)">
            @endauth
            @error('author_name')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg mb-5">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} 
                       class="w-5 h-5 border-gray-300 rounded shadow-sm text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300">
                <span class="ml-3 text-gray-700">
                    <i class="fas fa-user-secret text-gray-600 mr-1"></i>
                    Comment anonymously
                </span>
            </label>
            <p class="text-sm text-gray-500 mt-2 ml-8">If you select this option, your name will not be displayed in the comment</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" id="resetCommentButton" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-eraser mr-2"></i>
                Reset
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-paper-plane mr-2"></i>
                Submit Comment
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preload comment information for sorting (caching dates)
        const commentsContainer = document.getElementById('commentsContainer');
        const comments = Array.from(commentsContainer.children);
        
        // Store dates in data attributes for faster sorting
        comments.forEach(comment => {
            const dateText = comment.querySelector('.text-xs')?.textContent.trim();
            if (dateText) {
                const date = new Date(dateText);
                // Store as timestamp for faster comparison
                comment.dataset.timestamp = date.getTime();
            }
        });
        
        // Comment sorting options
        document.getElementById('commentSort').addEventListener('change', function() {
            const comments = Array.from(commentsContainer.children);
            
            if (this.value === 'oldest') {
                // Sort from oldest to newest
                comments.sort((a, b) => {
                    return (a.dataset.timestamp || 0) - (b.dataset.timestamp || 0);
                });
            } else {
                // Sort from newest to oldest
                comments.sort((a, b) => {
                    return (b.dataset.timestamp || 0) - (a.dataset.timestamp || 0);
                });
            }
            
            // Clear and add comments back in sorted order
            commentsContainer.innerHTML = '';
            const fragment = document.createDocumentFragment();
            comments.forEach(comment => fragment.appendChild(comment));
            commentsContainer.appendChild(fragment);
        });
        
        // Reset comment form function
        document.getElementById('resetCommentButton').addEventListener('click', function() {
            // Create effect when reset button is clicked
            const inputs = [
                document.getElementById('content'),
                document.getElementById('author_name')
            ];
            
            inputs.forEach(input => {
                if (input.value) {
                    input.classList.add('bg-red-50');
                    setTimeout(() => {
                        input.value = '';
                        input.classList.remove('bg-red-50');
                    }, 300);
                }
            });
            
            document.getElementById('is_anonymous').checked = false;
            
            // Show confirmation message for reset
            const form = document.getElementById('commentForm');
            const message = document.createElement('div');
            message.className = 'mt-3 mb-4 text-sm text-center text-green-700 bg-green-100 p-2 rounded';
            message.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Comment form has been reset successfully';
            form.insertAdjacentElement('afterbegin', message);
            
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    message.remove();
                }, 500);
            }, 2000);
        });
        
        // Open-close share menu
        const shareButton = document.querySelector('#shareDropdown button');
        const shareMenu = document.getElementById('shareMenu');
        
        if (shareButton && shareMenu) {
            shareButton.addEventListener('click', function(e) {
                e.stopPropagation();
                shareMenu.classList.toggle('hidden');
            });
            
            // Close menu when clicking outside menu
            document.addEventListener('click', function() {
                shareMenu.classList.add('hidden');
            });
            
            shareMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
    
    // Share via social media functions
    function shareViaFacebook() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank');
    }
    
    function shareViaTwitter() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank');
    }
    
    function shareViaLine() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://social-plugins.line.me/lineit/share?url=${url}`, '_blank');
    }
    
    function copyLink() {
        const el = document.createElement('textarea');
        el.value = window.location.href;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        
        // Show copied message
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Link copied successfully';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 2000);
    }
    
    // Share via social media functions
    function generatePDF() {
        // Show downloading message
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-blue-100 text-blue-800 px-4 py-2 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-file-download mr-2"></i> Preparing PDF...';
        document.body.appendChild(notification);
        
        // In real scenario, use library to generate PDF like jsPDF or send request to backend
        // This example is only for simulation
        setTimeout(() => {
            notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> PDF download successful';
            notification.className = 'fixed bottom-4 right-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-lg z-50';
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 2000);
        }, 1500);
    }
</script>
@endsection 