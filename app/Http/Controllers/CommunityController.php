<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\CommunityPostLike;

class CommunityController extends Controller
{

    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->type
        ];

        $posts = CommunityPost::with(['user', 'comments', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('community.index', compact('user_details','posts'));
    }
    
    public function storePost(Request $request)
    {
        $request->validate(['content' => 'required|string|max:255']);
        CommunityPost::create(['user_id' => Auth::id(), 'content' => $request->content]);
        return back()->with('success', 'Post created successfully.');
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = new CommunityComment();
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->comment = $request->input('comment');
        $comment->save();
    
        return back()->with('success', 'Comment added successfully!');
    }

    public function deletePost($id)
    {
        $post = CommunityPost::findOrFail($id);
        if (Auth::user()->user_type == 'management' || Auth::id() == $post->user_id) {
            $post->delete();
            return back()->with('success', 'Post deleted successfully.');
        }
        return back()->with('error', 'Unauthorized action.');
    }

    public function likePost(Request $request, $postId)
    {
        $post = CommunityPost::findOrFail($postId);
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user->id);
            $post->decrement('likes_count');
        } else {
            $post->likes()->attach($user->id);
            $post->increment('likes_count');
        }

        return back();
    }
}
