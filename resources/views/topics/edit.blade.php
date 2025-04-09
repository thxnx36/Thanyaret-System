@extends('layouts.app')

@section('title', 'แก้ไขหัวข้อ')

@section('content')
<div class="mb-5" data-aos="fade-right">
    <a href="{{ route('topics.show', $topic) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i> กลับไปยังหัวข้อ
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover" data-aos="fade-up">
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-5">
        <div class="flex items-center">
            <div class="bg-white rounded-full p-2 text-blue-600 mr-3 shadow-md">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">แก้ไขหัวข้อ</h1>
        </div>
    </div>
    
    <form action="{{ route('topics.update', $topic) }}" method="POST" id="editTopicForm" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid md:grid-cols-1 gap-6">
            <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <label for="title" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-heading text-gray-600 mr-1"></i>
                    หัวข้อ <span class="text-red-600">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $topic->title) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 @error('title') border-red-500 @enderror"
                       required placeholder="ระบุหัวข้อที่ต้องการแก้ไข">
                @error('title')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <div class="mb-5" data-aos="fade-up" data-aos-delay="150">
                <label for="content" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-align-left text-gray-600 mr-1"></i>
                    เนื้อหา
                </label>
                <textarea name="content" id="content" rows="6" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 @error('content') border-red-500 @enderror"
                          placeholder="อธิบายรายละเอียดเพิ่มเติม...">{{ old('content', $topic->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                <label for="author_name" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-user text-gray-600 mr-1"></i>
                    ชื่อผู้เขียน
                </label>
                <input type="text" name="author_name" id="author_name" value="{{ old('author_name', $topic->author_name) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 @error('author_name') border-red-500 @enderror"
                       placeholder="ระบุชื่อผู้เขียน (ถ้าไม่ระบุจะแสดงเป็น anonymous)">
                @error('author_name')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-6" data-aos="fade-up" data-aos-delay="250">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" 
                           {{ old('is_anonymous', $topic->is_anonymous) ? 'checked' : '' }}
                           class="w-5 h-5 border-gray-300 rounded shadow-sm text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300">
                    <span class="ml-3 text-gray-700">
                        <i class="fas fa-user-secret text-gray-600 mr-1"></i>
                        ไม่ระบุตัวตนผู้เขียน
                    </span>
                </label>
                <p class="text-sm text-gray-500 mt-2 ml-8">หากเลือกตัวเลือกนี้ ชื่อของคุณจะไม่ถูกแสดงในหัวข้อ</p>
            </div>
        </div>
        
        <div class="flex gap-3 justify-end">
            <a href="{{ route('topics.show', $topic) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 flex items-center">
                <i class="fas fa-times mr-2"></i>
                ยกเลิก
            </a>
            <button type="button" id="resetEditButton" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 flex items-center">
                <i class="fas fa-eraser mr-2"></i>
                รีเซ็ต
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 flex items-center">
                <i class="fas fa-save mr-2"></i>
                บันทึกการแก้ไข
            </button>
        </div>
    </form>
</div>

<div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6 rounded-lg shadow-sm" data-aos="fade-up" data-aos-delay="300">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-blue-500"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-blue-800 font-medium">คำแนะนำในการแก้ไขหัวข้อ</h3>
            <div class="text-blue-700 text-sm mt-2">
                <ul class="list-disc ml-5 space-y-1">
                    <li>ตั้งหัวข้อที่เข้าใจง่ายและตรงประเด็น</li>
                    <li>ระบุเนื้อหาที่ชัดเจนและครบถ้วน</li>
                    <li>ตรวจสอบความถูกต้องก่อนบันทึกการแก้ไข</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ฟังก์ชันรีเซ็ตฟอร์มแก้ไขหัวข้อ
        document.getElementById('resetEditButton').addEventListener('click', function() {
            // สร้างเอฟเฟคเมื่อกดรีเซ็ต
            const inputs = [
                document.getElementById('title'), 
                document.getElementById('content'),
                document.getElementById('author_name')
            ];
            
            const originalValues = {
                title: '{{ $topic->title }}',
                content: '{{ $topic->content }}',
                author_name: '{{ $topic->author_name }}',
                is_anonymous: {{ $topic->is_anonymous ? 'true' : 'false' }}
            };
            
            inputs.forEach(input => {
                input.classList.add('bg-yellow-50');
                setTimeout(() => {
                    if (input.id in originalValues) {
                        input.value = originalValues[input.id];
                    }
                    input.classList.remove('bg-yellow-50');
                }, 300);
            });
            
            document.getElementById('is_anonymous').checked = originalValues.is_anonymous;
            
            // แสดงข้อความยืนยันการรีเซ็ต
            const form = document.getElementById('editTopicForm');
            const message = document.createElement('div');
            message.className = 'mt-3 mb-4 text-sm text-center text-amber-700 bg-amber-100 p-2 rounded';
            message.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> รีเซ็ตฟอร์มกลับสู่ค่าเริ่มต้นเรียบร้อยแล้ว';
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