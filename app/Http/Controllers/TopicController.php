<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $topics = Topic::latest()->get();
            Log::info('Topics list viewed');
            
            return view('topics.index', compact('topics'));
        } catch (\Exception $e) {
            Log::error('Error fetching topics: ' . $e->getMessage());
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
            $topic = Topic::create([
                'title' => $request->title,
                'content' => $request->content,
                'author_name' => $request->is_anonymous ? null : $request->author_name,
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
