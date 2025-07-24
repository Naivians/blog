@extends('layout.app')

@section('main-content')
    <div class="container py-5" style="margin-top: 40px;">
        <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="post" id="post" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-100">Post</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="post" id="post" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-100">Update Post</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-50 mx-auto border rounded p-2" id="post-btn-input" role="button" tabindex="0"
            data-bs-toggle="modal" data-bs-target="#postModal">
            What's on your mind {{ Auth::user()->name }}?
        </div>

        <div class="card mb-3 shadow-sm w-50 mx-auto mt-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 justify-content-between border-bottom pb-2">
                    <div class="d-flex align-items-center">
                        <img src="https://images.pexels.com/photos/897817/pexels-photo-897817.jpeg"
                            class="rounded-circle me-2" alt="User" style="width: 50px; height: 50px;" />
                        <div>
                            <h6 class="mb-0 fw-bold">John Doe</h6>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                    <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                        style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                        <ul class="dropdown-menu">
                            <li><span class="dropdown-item" onclick="editPost(1)" >Edit</span></li>
                            <li><span class="dropdown-item" onclick="deletePost(1)" >Delete</span></li>
                        </ul>
                    </div>
                </div>
                <p class="mb-3">
                    This is a sample post caption that looks like something you'd see on Facebook.
                </p>

                <div class="d-flex justify-content-between text-center border-top pt-2">
                    {{-- <button class="btn btn-light flex-fill border-end">
                        👍 Like
                    </button> --}}
                    <button class="btn btn-light flex-fill border-end">
                        💬 Comment
                    </button>
                    {{-- <button class="btn btn-light flex-fill">
                        ↪️ Share
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function editPost(post_id){
        $('#editPost').modal('show')
    }

    function deletePost(post_id){
        deleteMessage("Yes, delete this post");
    }
</script>
@endsection
