@extends('layouts.app')

@section('title', 'รายการหัวข้อ')

@section('content')
<div class="mb-6 flex justify-between items-center" data-aos="fade-up">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">หัวข้อการสนทนา</h1>
    <a href="{{ route('topics.create') }}" class="btn-hover inline-flex items-center bg-red-800 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-300">
        <i class="fas fa-plus-circle mr-2"></i> หัวข้อใหม่
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden card-hover" data-aos="fade-up" data-aos-delay="100">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-4 px-6 text-left text-gray-700 font-semibold">หัวข้อ</th>
                    <th class="py-4 px-6 text-center text-gray-700 font-semibold">ความคิดเห็น</th>
                    <th class="py-4 px-6 text-center text-gray-700 font-semibold">ความคิดเห็นล่าสุด</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($topics as $topic)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="py-4 px-6">
                        <a href="{{ route('topics.show', $topic) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-all duration-200">
                            {{ $topic->title }}
                        </a>
                        <p class="text-gray-500 text-sm mt-1">โดย: {{ $topic->getDisplayAuthorAttribute() }} • {{ $topic->created_at->locale('th')->diffForHumans() }}</p>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="inline-flex items-center justify-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                            {{ $topic->comments_count }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if ($topic->comments->isNotEmpty())
                            <div class="text-sm text-gray-600">
                                {{ $topic->comments->sortByDesc('created_at')->first()->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="text-blue-600 font-medium mt-1">
                                {{ $topic->comments->sortByDesc('created_at')->first()->getDisplayAuthorAttribute() }}
                            </div>
                        @else
                            <div class="text-gray-500 italic">ยังไม่มีความคิดเห็น</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-comment-slash text-4xl mb-3 text-gray-400"></i>
                            <p class="text-lg">ยังไม่มีหัวข้อในขณะนี้</p>
                            <p class="mt-2">คุณสามารถเป็นคนแรกที่สร้างหัวข้อใหม่ได้!</p>
                            <a href="{{ route('topics.create') }}" class="mt-4 inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-all duration-300">
                                <i class="fas fa-plus-circle mr-2"></i> สร้างหัวข้อใหม่
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 bg-gradient-to-r from-red-700 to-red-900 text-white p-6 rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
    <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-3/4">
            <h2 class="text-xl font-bold mb-2">มีไอเดียใหม่ๆ ที่ต้องการแชร์?</h2>
            <p class="mb-4 md:mb-0">แบ่งปันความคิดเห็นของคุณกับเพื่อนร่วมงานเพื่อพัฒนาองค์กรไปด้วยกัน</p>
        </div>
        <div class="md:w-1/4 text-center md:text-right">
            <a href="{{ route('topics.create') }}" class="inline-block bg-white text-red-800 hover:bg-gray-100 font-semibold px-5 py-2 rounded-lg transition-all duration-300">
                สร้างหัวข้อใหม่
            </a>
        </div>
    </div>
</div>
@endsection 