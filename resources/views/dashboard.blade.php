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
                        <form id="postForm">
                            <textarea name="post" id="post" cols="30" rows="10" class="form-control"
                                placeholder="Write something...."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Post</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPostForm">
                            <textarea name="editPost" id="editPost" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Update Post</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mx-auto border rounded p-2" id="post-btn-input" role="button" tabindex="0" data-bs-toggle="modal"
            data-bs-target="#postModal">
            What's on your mind {{ Auth::user()->name }}?
        </div>

        <div id="postComments">

        </div>
    </div>


    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3 z-1050"></div>
    </div>

    <script></script>
@endsection
