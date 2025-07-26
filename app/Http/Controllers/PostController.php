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
        $posts = Post::with(['user', 'comments.user'])->orderBy('created_at', 'desc')->get();

        $htmlPost = '';
        foreach ($posts as $post) {
            $randomImg = 'https://randomuser.me/api/portraits/men/' . rand(1, 99) . '.jpg';
            $htmlPost .= '
            <div class="card mb-3 shadow-sm  mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="' . $post->user->img . '"
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
                                <img src="' . $comments->user->img . '" class="rounded-circle me-2"
                                    alt="User" style="width: 40px; height: 40px;" />
                                <div>
                                    <h6 class="mb-0 fw-bold small">' . $comments->user->name . '</h6>
                                </div>
                            </div>
                            <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                                style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item" onclick="editComment(' . $comments->id . ')">Edit</span></li>
                                    <li><span class="dropdown-item" onclick="deletePost(null,' . $comments->id . ')">Delete</span></li>
                                </ul>
                            </div>
                        </div>
                        ' . $comments->comment . '
                        <br>

                        <div id="nested_commentContainer-' . $comments->id . '" class="my-3 d-none">
                                <textarea name="comment" id="nested_comment-' . $comments->id . '" cols="30" rows="3" placeholder="Write a comment..."
                                    class="form-control mb-2"></textarea>
                                <button type="button" class="btn btn-outline-primary" onclick="updateComment(' . $comments->id . ')">
                                    Send
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
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

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => "Failed to create post"
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    function destroyPost($post_id)
    {
        $post = $this->postModel->find($post_id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => "Post id do not exist"
            ]);
        }

        if (!$post->delete()) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete post."
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted post"
        ]);
    }

    function showPost($post_id)
    {
        $post = $this->postModel->find($post_id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => "Post id do not exist"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    function updatePost(Request $request)
    {
        $post = $this->postModel->find($request->post_id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => "Post id do not exist"
            ]);
        }

        $post = $post->update([
            'post' => $request->editPost
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully update post"
        ]);
    }

    // comments
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
            'attachment' => 'null',
            'user_id' => Auth::id()
        ]);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => "Failed to create post"
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    function destroyComment($comment_id)
    {
        $comment = $this->commentModel->find($comment_id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => "Comment id do not exist"
            ]);
        }

        if (!$comment->delete()) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete comment."
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted comment"
        ]);
    }

    function showComment($comment_id)
    {
        $comment = $this->commentModel->find($comment_id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => "Comment id do not exist"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }

    function updateComment(Request $request)
    {
        $comment = $this->commentModel->find($request->comment_id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => "Post id do not exist"
            ]);
        }

        $comment = $comment->update([
            'comment' => $request->commentText
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully update comment"
        ]);
    }
}
