<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentController extends Controller {
    public function index() {
        
    }

    public function createComment(StoreCommentRequest $request) {
        try {
            $posts = Post::where('id', $request->post_id)->first();
            if(!empty($posts)) {
                $comment = new Comment();
                $comment->post_id = $request->post_id;
                $comment->comment = $request->comment;
                // $comment->user_id = auth()->user()->id; // when user is logged in then used this method
                // $comment->user()->associate($request->user()); // when user is logged in then used this method
                // $posts->comments()->save($comment); // when user is logged in then used this method
                $comment->user_id = $request->user_id;
                $comment->parent_id = $request->parent_id;
                return $comment;
                $comment->save();
                return new CommentResource($comment);
            }

        } catch(Exception $e){ 
            Log::info('Add post details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error While Adding Post Details'
            ]));
        }
    }   
    public function updateComment(UpdateCommentRequest $request) {

    }

    public function deleteComment(Request $request) {
        
    }
}
