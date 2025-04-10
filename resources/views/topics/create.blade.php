@extends('layouts.app')

@section('title', 'Create New Topic')

@section('content')
<div class="mb-4" data-aos="fade-right">
    <a href="{{ route('topics.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i> Back to Topic List
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg p-6 card-hover" data-aos="fade-up" data-aos-delay="100">
    <div class="flex items-center mb-6">
        <div class="bg-red-800 rounded-full p-3 text-white mr-4">
            <i class="fas fa-pen-to-square text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Create New Topic</h2>
    </div>
    
    <form action="{{ route('topics.store') }}" method="POST" id="createTopicForm">
        @csrf
        
        <div class="mb-5">
            <label for="title" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-heading text-gray-600 mr-1"></i>
                Title <span class="text-red-600">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('title') border-red-500 @enderror"
                   required placeholder="Enter discussion topic title">
            @error('title')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
        
        <div class="mb-5">
            <label for="content" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-align-left text-gray-600 mr-1"></i>
                Content
            </label>
            <textarea name="content" id="content" rows="5" 
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('content') border-red-500 @enderror"
                      placeholder="Additional details about this topic">{{ old('content') }}</textarea>
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
                Author Name
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
        
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} 
                       class="w-5 h-5 border-gray-300 rounded shadow-sm text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300">
                <span class="ml-3 text-gray-700">
                    <i class="fas fa-user-secret text-gray-600 mr-1"></i>
                    Post anonymously
                </span>
            </label>
            <p class="text-sm text-gray-500 mt-2 ml-8">If you select this option, your name will not be displayed in the post</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('topics.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-5 rounded-lg transition-all duration-300 flex items-center">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
            <button type="button" id="resetButton" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-eraser mr-2"></i>
                Reset
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-paper-plane mr-2"></i>
                Create Topic
            </button>
        </div>
    </form>
</div>

<div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6 rounded-lg shadow-sm" data-aos="fade-up" data-aos-delay="200">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-blue-600 text-xl"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-blue-800 font-medium">Topic Creation Guidelines</h3>
            <ul class="mt-2 text-sm text-blue-700 space-y-1">
                <li>• Create short and clear titles for easy understanding</li>
                <li>• Provide relevant details to facilitate effective discussion</li>
                <li>• Respect others' opinions and use polite language</li>
                <li>• Avoid posting sensitive personal information</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form reset function
        document.getElementById('resetButton').addEventListener('click', function() {
            // Create effect when reset button is clicked
            const inputs = [
                document.getElementById('title'),
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
            const form = document.getElementById('createTopicForm');
            const message = document.createElement('div');
            message.className = 'mt-3 mb-4 text-sm text-center text-green-700 bg-green-100 p-2 rounded';
            message.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Form has been reset successfully';
            form.insertAdjacentElement('afterbegin', message);
            
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    message.remove();
                }, 500);
            }, 2000);
        });
    });
</script>
@endsection 