<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $users = User::count();
        $topics = Topic::count();
        $comments = Comment::count();
        
        $latestUsers = User::latest()->take(5)->get();
        
        // Get top 3 popular topics with most comments
        $popularTopics = Topic::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(3)
            ->get();
        
        // Add more sample posts
        $latestTopics = Topic::with('comments')->latest()->take(15)->get();
        
        return view('admin.dashboard', compact('users', 'topics', 'comments', 'latestUsers', 'latestTopics', 'popularTopics'));
    }
    
    /**
     * Display all users list
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show user edit form
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update user information
     */
    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:user,admin'],
        ]);
        
        $user->update($validatedData);
        
        return redirect()->route('admin.users')->with('success', 'User information has been updated successfully');
    }
    
    /**
     * Delete a user
     */
    public function destroyUser(User $user)
    {
        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User has been deleted successfully');
    }
    
    /**
     * Display all topics
     */
    public function topics()
    {
        $topics = Topic::withCount('comments')->latest()->paginate(10);
        return view('admin.topics.index', compact('topics'));
    }
    
    /**
     * Show topic details
     */
    public function showTopic(Topic $topic)
    {
        $topic->load('comments');
        return view('admin.topics.show', compact('topic'));
    }
    
    /**
     * Delete a topic
     */
    public function destroyTopic(Topic $topic)
    {
        // Delete all related comments first
        $topic->comments()->delete();
        $topic->delete();
        
        return redirect()->route('admin.topics')->with('success', 'Topic and all related comments have been deleted successfully');
    }
    
    /**
     * Display all comments
     */
    public function comments()
    {
        $comments = Comment::with('topic')->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }
    
    /**
     * Delete a comment
     */
    public function destroyComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments')->with('success', 'Comment has been deleted successfully');
    }
}
