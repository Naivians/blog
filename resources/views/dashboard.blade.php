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

        <div id="postComments">

        </div>
    </div>

    {{--
     <div id="commentsContainer">
                        <div class="rounded mt-2 mt-3 ms-5">
                            <div class="d-flex align-items-center mb-2 justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://images.pexels.com/photos/897817/pexels-photo-897817.jpeg"
                                        class="rounded-circle me-2" alt="User" style="width: 40px; height: 40px;" />
                                    <div>
                                        <h6 class="mb-0 fw-bold small">John Doe</h6>
                                    </div>
                                </div>
                                <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                                    style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                                    <ul class="dropdown-menu">
                                        <li><span class="dropdown-item" onclick="editPost(1)">Edit</span></li>
                                        <li><span class="dropdown-item" onclick="deletePost(1)">Delete</span></li>
                                    </ul>
                                </div>
                            </div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, quae reprehenderit. Molestiae,
                            commodi.
                            Error illo nesciunt, accusamus possimus ducimus corrupti.
                            <br>
                            <small role="button" class="badge bg-secondary text-light" id="reply_comment">Reply</small>

                            <div id="nested_commentContainer" class="my-3 d-none">
                                <form id="commentForm">
                                    <textarea name="comment" id="comment" cols="30" rows="3" placeholder="Write a comment..."
                                        class="form-control mb-2"></textarea>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-comment"></i>
                                        comment
                                    </button>
                                </form>
                            </div>

                            <div class="rounded mt-2 mt-3 ms-5">
                                <div class="d-flex align-items-center mb-2 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.pexels.com/photos/897817/pexels-photo-897817.jpeg"
                                            class="rounded-circle me-2" alt="User"
                                            style="width: 40px; height: 40px;" />
                                        <div>
                                            <h6 class="mb-0 fw-bold small">John Doe</h6>
                                        </div>
                                    </div>
                                    <div class="rounded-circle text-center p-4 d-flex align-items-center justify-content-center icon-hover dropdown-toggle"
                                        style="width: 30px; height: 30px;" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical fs-5"></i>

                                        <ul class="dropdown-menu">
                                            <li><span class="dropdown-item" onclick="editPost(1)">Edit</span></li>
                                            <li><span class="dropdown-item" onclick="deletePost(1)">Delete</span></li>
                                        </ul>
                                    </div>
                                </div>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, quae reprehenderit.
                                Molestiae,
                                commodi. Error illo nesciunt, accusamus possimus ducimus corrupti.
                                <br>
                                <small role="button" class="text-decoration-underline text-muted">Reply</small>
                            </div>
                        </div>
                    </div>
    --}}
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(() => {
            renderPost();
        })

        $('#postForm').on('submit', function(e) {
            e.preventDefault()

            const form = this;
            const formData = $(form).serialize();
            $(form).find('button[type="submit"]').prop("disabled", true);

            $.ajax({
                url: "/posts/store",
                method: "POST",
                data: formData,
                success: (res) => {
                    if (!res.success) {
                        error_message(res.message)
                    }
                    renderPost()
                    form.reset();

                }
            });
        });

        function renderPost() {
            $.ajax({
                url: '/posts',
                method: "GET",
                success: (res) => {
                    $('#postComments').empty()
                    $('#postComments').append(res.data);
                    $('#postModal').modal('hide');
                }
            });
        }

        $(document).on('submit', 'form[id^="commentForm-"]', function(e) {
            e.preventDefault();

            const form = $(this);
            const post_id = form.attr('id').split('-')[1];
            const comment = $(`#comment-${post_id}`).val();

            $.ajax({
                url: 'posts/comment/store',
                method: "POST",
                data: {
                    post_id: post_id,
                    comment: comment
                },
                success: (res) => {
                    console.log(res);
                    renderPost()
                    $(`#commentBoxContainer-${post_id}`).toggleClass('d-none');
                    $(`#comment-${post_id}`).val('')
                }
            });


        });

        function editPost(post_id) {
            $('#editPost').modal('show')
        }

        function deletePost(post_id) {
            deleteMessage("Yes, delete this post");
        }

        function comment(post_id) {
            $(`#commentBoxContainer-${post_id}`).toggleClass('d-none');
            $(`#comment-${post_id}`).focus();
        }

        $('#reply_comment').on('click', () => {
            $('#nested_commentContainer').toggleClass('d-none')
        })
    </script>
@endsection
