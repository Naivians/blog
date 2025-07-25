<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class PostController extends Controller
{
    private $postModel;
    private $commentModel;
    public function __construct(Post $postModel, Comment $commentModel)
    {
        $this->postModel = $postModel;
        $this->commentModel = $commentModel;
    }

    function post()
    {
        $posts = Post::with(['user', 'comments'])->orderBy('created_at', 'desc')->get();

        $htmlPost = '';
        foreach ($posts as $post) {
            $randomImg = 'https://randomuser.me/api/portraits/men/' . rand(1, 99) . '.jpg';
            $htmlPost .= '
            <div class="card mb-3 shadow-sm w-50 mx-auto mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="' . $randomImg . '"
                                    class="rounded-circle me-2" alt="User" style="width: 50px; height: 50px;" />
                                <div>
                                    <h6 class="mb-0 fw-bold">' . $post->user->name . '</h6>
                                    <small class="text-muted">' . $post->created_at->diffForHumans(['parts' => 1, 'short' => true]) . '</small>
                                </div>
                            </div>
                            <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                                style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item" onclick="editPost(' . $post->id . ')">Edit</span></li>
                                    <li><span class="dropdown-item" onclick="deletePost(' . $post->id . ')">Delete</span></li>
                                </ul>
                            </div>
                        </div>

                        <p class="mb-3">
                            ' . $post->post . '
                        </p>

                        <div class="d-flex justify-content-between text-center border-top pt-2">
                            <button class="btn btn-light flex-fill border-end" onclick="comment(' . $post->id . ')">
                                💬 Comment
                            </button>
                        </div>

                        <div id="commentBoxContainer-' . $post->id . '" class="my-3 d-none">
                            <form id="commentForm-' . $post->id . '" >
                                <textarea name="comment-' . $post->id . '" id="comment-' . $post->id . '" cols="30" rows="3" placeholder="Write a comment..."
                                    class="form-control mb-2"></textarea>
                                <input type="submit" value="submit" class="btn btn-outline-primary">
                            </form>
                        </div>
            ';

            foreach ($post->comments as $comments) {
                $randomImg = 'https://randomuser.me/api/portraits/men/' . rand(1, 99) . '.jpg';
                $htmlPost .= '
                    <div class="rounded mt-2 mt-3 border-bottom bg-light p-3 ">
                        <div class="d-flex align-items-center mb-2 justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="' . $randomImg . '" class="rounded-circle me-2"
                                    alt="User" style="width: 40px; height: 40px;" />
                                <div>
                                    <h6 class="mb-0 fw-bold small">John Doe</h6>
                                </div>
                            </div>
                            <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                                style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item" onclick="editPost(1)">Edit</span></li>
                                    <li><span class="dropdown-item" onclick="deletePost(1)">Delete</span></li>
                                </ul>
                            </div>
                        </div>
                        ' . $comments->comment . '
                        <br>
                        <small role="button" class="badge bg-secondary text-light mt-3" id="reply_comment">Reply</small>
                    </div>
                ';
            }

            $htmlPost .= '</div>
                </div>';
        }

        return response()->json([
            'success' => true,
            'data' => $htmlPost
        ]);
    }

    function storePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $post = $this->postModel->create([
            'user_id' => Auth::id(),
            'post' => $request->post
        ]);

        if(!$post){
             return response()->json([
                'success' => false,
                'message' => "Failed to create post"
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
    function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $comment = $this->commentModel->create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'attachment' => 'null'
        ]);

         if(!$comment){
             return response()->json([
                'success' => false,
                'message' => "Failed to create post"
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
