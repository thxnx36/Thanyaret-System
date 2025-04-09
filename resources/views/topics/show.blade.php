@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<div class="mb-5" data-aos="fade-right">
    <a href="{{ route('topics.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i> กลับไปยังรายการหัวข้อ
    </a>
</div>

<!-- รายละเอียดหัวข้อ -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6 card-hover" data-aos="fade-up">
    <div class="border-b border-gray-200 pb-4 mb-4">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 text-gray-800">{{ $topic->title }}</h1>
        
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
            {!! nl2br(e($topic->content)) !!}
        @else
            <p class="text-gray-500 italic">ไม่มีเนื้อหาเพิ่มเติม</p>
        @endif
    </div>
</div>

<!-- ความคิดเห็น -->
<div class="mb-6" data-aos="fade-up" data-aos-delay="100">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-comments text-blue-600 mr-2"></i>
            ความคิดเห็น 
            <span class="ml-2 bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm">
                {{ $topic->comments_count }}
            </span>
        </h2>
    </div>
    
    <div class="space-y-4">
        @forelse ($topic->comments->sortByDesc('created_at') as $comment)
        <div class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-md" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
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
        <div class="bg-white rounded-lg shadow p-6 text-center" data-aos="fade-up">
            <img src="https://illustrations.popsy.co/gray/discussion.svg" alt="No Comments" class="w-48 h-48 mx-auto mb-4">
            <p class="text-gray-500 text-lg">ยังไม่มีความคิดเห็นสำหรับหัวข้อนี้</p>
            <p class="text-gray-600 mt-2">คุณสามารถเป็นคนแรกที่แสดงความคิดเห็นได้!</p>
        </div>
        @endforelse
    </div>
</div>

<!-- ฟอร์มแสดงความคิดเห็น -->
<div class="bg-white rounded-lg shadow-lg p-6 card-hover" data-aos="fade-up" data-aos-delay="200">
    <div class="flex items-center mb-5">
        <div class="bg-green-600 rounded-full p-2 text-white mr-3">
            <i class="fas fa-comment-dots text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">แสดงความคิดเห็น</h2>
    </div>
    
    <form action="{{ route('comments.store', $topic) }}" method="POST" id="commentForm">
        @csrf
        
        <div class="mb-5">
            <label for="content" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-comment text-gray-600 mr-1"></i>
                ความคิดเห็นของคุณ <span class="text-red-600">*</span>
            </label>
            <textarea name="content" id="content" rows="4" 
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('content') border-red-500 @enderror"
                      required placeholder="แสดงความคิดเห็นของคุณที่นี่...">{{ old('content') }}</textarea>
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
                ชื่อของคุณ
            </label>
            <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" 
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 form-input transition-all duration-300 @error('author_name') border-red-500 @enderror"
                   placeholder="ชื่อของคุณ (ถ้าไม่ระบุจะแสดงเป็น anonymous)">
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
                    แสดงความคิดเห็นแบบไม่ระบุตัวตน
                </span>
            </label>
            <p class="text-sm text-gray-500 mt-2 ml-8">หากเลือกตัวเลือกนี้ ชื่อของคุณจะไม่ถูกแสดงในความคิดเห็น</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" id="resetCommentButton" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-eraser mr-2"></i>
                รีเซ็ต
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 btn-hover flex items-center">
                <i class="fas fa-paper-plane mr-2"></i>
                ส่งความคิดเห็น
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ฟังก์ชันรีเซ็ตฟอร์มความคิดเห็น
        document.getElementById('resetCommentButton').addEventListener('click', function() {
            // สร้างเอฟเฟคเมื่อกดรีเซ็ต
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
            
            // แสดงข้อความยืนยันการรีเซ็ต
            const form = document.getElementById('commentForm');
            const message = document.createElement('div');
            message.className = 'mt-3 mb-4 text-sm text-center text-green-700 bg-green-100 p-2 rounded';
            message.innerHTML = '<i class="fas fa-check-circle mr-1"></i> รีเซ็ตฟอร์มความคิดเห็นเรียบร้อยแล้ว';
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