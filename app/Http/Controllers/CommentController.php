<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('topics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('topics.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'is_anonymous' => 'boolean',
        ]);
        
        try {
            DB::transaction(function () use ($request, $topic) {
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
                
                // สร้างความคิดเห็นใหม่
                $comment = $topic->comments()->create([
                    'content' => $request->content,
                    'author_name' => $authorName,
                    'is_anonymous' => $request->is_anonymous ?? false,
                ]);
                
                // อัปเดตจำนวนความคิดเห็นในหัวข้อ
                $topic->increment('comments_count');
                
                Log::info('New comment created', [
                    'comment_id' => $comment->id,
                    'topic_id' => $topic->id
                ]);
            });
            
            return redirect()->route('topics.show', $topic)->with('success', 'ความคิดเห็นของคุณถูกเพิ่มเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            Log::error('Error creating comment: ' . $e->getMessage(), ['topic_id' => $topic->id]);
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มความคิดเห็น กรุณาลองใหม่อีกครั้ง')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('topics.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('topics.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('topics.index');
    }
}
