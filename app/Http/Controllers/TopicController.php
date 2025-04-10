<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // จัดเรียงตามตัวเลือกที่เลือก
            $sort = $request->input('sort', 'latest');
            
            // สร้าง query
            $query = Topic::query();
            
            // ค้นหาหัวข้อตามคำค้น (ถ้ามี)
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('topics.title', 'like', "%{$search}%")
                      ->orWhere('topics.content', 'like', "%{$search}%");
                });
            }
            
            // ทำ withCount ก่อนเพื่อให้แน่ใจว่ามีการนับที่ถูกต้อง
            $query->withCount('comments');
            
            // เรียงลำดับตามตัวเลือก
            if ($sort === 'oldest') {
                $query->oldest('topics.created_at'); // เรียงจากเก่าไปใหม่
            } else {
                $query->latest('topics.created_at'); // เรียงจากใหม่ไปเก่า (ค่าเริ่มต้น)
            }
            
            // ใช้ paginate แทน get และส่งคำขอค้นหาไปด้วย
            $perPage = 10; // จำนวนรายการต่อหน้า
            $topics = $query->paginate($perPage)->withQueryString();
            
            // โหลดความสัมพันธ์สำหรับแสดงผลความคิดเห็นล่าสุด
            $topics->getCollection()->load(['comments' => function($query) {
                $query->latest('created_at');
            }]);
            
            Log::info('Topics list viewed', ['sort' => $sort]);
            
            return view('topics.index', compact('topics'));
        } catch (\Exception $e) {
            Log::error('Error fetching topics: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการโหลดหัวข้อ กรุณาลองใหม่อีกครั้ง');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Topic creation form viewed');
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'is_anonymous' => 'boolean',
        ]);
        
        try {
            // กำหนดชื่อผู้เขียน
            $authorName = null;
            
            // ถ้าไม่ได้เลือกไม่ระบุตัวตน
            if (!($request->is_anonymous ?? false)) {
                // ถ้าล็อกอินอยู่ ใช้ชื่อผู้ใช้จากบัญชี
                if (auth()->check()) {
                    $authorName = auth()->user()->name;
                } 
                // ถ้าไม่ได้ล็อกอิน แต่มีการระบุชื่อมา
                else if ($request->filled('author_name')) {
                    $authorName = $request->author_name;
                }
            }
            
            $topic = Topic::create([
                'title' => $request->title,
                'content' => $request->content,
                'author_name' => $authorName,
                'is_anonymous' => $request->is_anonymous ?? false,
            ]);
            
            Log::info('New topic created', ['topic_id' => $topic->id]);
            
            return redirect()->route('topics.show', $topic)->with('success', 'หัวข้อใหม่ถูกสร้างเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            Log::error('Error creating topic: ' . $e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการสร้างหัวข้อ กรุณาลองใหม่อีกครั้ง')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        try {
            $topic->load('comments');
            Log::info('Topic viewed', ['topic_id' => $topic->id]);
            
            return view('topics.show', compact('topic'));
        } catch (\Exception $e) {
            Log::error('Error showing topic: ' . $e->getMessage(), ['topic_id' => $topic->id]);
            return redirect()->route('topics.index')->with('error', 'เกิดข้อผิดพลาดในการแสดงหัวข้อ กรุณาลองใหม่อีกครั้ง');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return redirect()->route('topics.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        return redirect()->route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        return redirect()->route('topics.index');
    }
}
