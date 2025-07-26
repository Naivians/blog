$(document).ready(() => {
    renderPost();
});

$("#postForm").on("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = $(form).serialize();
    $(form).find('button[type="submit"]').prop("disabled", true);

    $.ajax({
        url: "/posts/store",
        method: "POST",
        data: formData,
        success: (res) => {
            if (!res.success) {
                error_message(res.message);
            }
            renderPost();
            form.reset();
        },
    });
});

function renderPost() {
    $.ajax({
        url: "/posts",
        method: "GET",
        success: (res) => {
            $("#postComments").empty();
            $("#postComments").append(res.data);
            $("#postModal").modal("hide");
        },
    });
}

$(document).on("submit", 'form[id^="commentForm-"]', function (e) {
    e.preventDefault();

    const form = $(this);
    const post_id = form.attr("id").split("-")[1];
    const comment = $(`#comment-${post_id}`).val();
    $.ajax({
        url: "posts/comment/store",
        method: "POST",
        data: {
            post_id: post_id,
            comment: comment,
        },
        success: (res) => {
            console.log(res);
            renderPost();
            $(`#commentBoxContainer-${post_id}`).toggleClass("d-none");
            $(`#comment-${post_id}`).val("");
        },
    });
});

function editPost(post_id = null, comment_id = null) {
    $.ajax({
        url: `posts/show/${post_id}`,
        method: "GET",
        data: {
            post_id: post_id,
        },
        success: (res) => {
            $("#editPostModal").modal("show");
            $("#editPost").val(res.data.post);
            localStorage.setItem("post_id", post_id);
        },
    });
}

$("#editPostForm").on("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    formData.append("post_id", localStorage.getItem("post_id"));
    $(form).find('button[type="submit"]').prop("disabled", true);

    $.ajax({
        url: `posts/update`,
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: (res) => {
            if (!res.success) {
                error_message(res.message);
                return;
            }

            form.reset();
            $("#editPostModal").modal("hide");
            showSuccessToast(res.message);
            renderPost();
            localStorage.removeItem("post_id");
        },
        complete: function () {
            $(form).find('button[type="submit"]').prop("disabled", true);
        },
    });
});

function deletePost(post_id = null, comment_id = null) {
    var endPointPartial;
    var ids;
    var data;
    var actionMsg;

    if (comment_id == null && post_id == null) {
        alert("both are null");
        return;
    }

    if (comment_id != null && post_id == null) {
        endPointPartial = "comment/destroy";
        data = { comment_id: comment_id };
        actionMsg = "comment";
        ids = comment_id;
    }

    if (post_id != null && comment_id == null) {
        ids = post_id;
        endPointPartial = "destroy";
        data = { post_id: post_id };
        actionMsg = "post";
    }

    var urlEndpoint = `/posts/${endPointPartial}/${ids}`;

    deleteMessage(`Yes, delete this ${actionMsg}`, () => {
        $.ajax({
            url: urlEndpoint,
            method: "POST",
            data: data,
            success: (res) => {
                if (!res.success) {
                    error_message(res.message);
                }

                showSuccessToast(res.message);
                renderPost();
            },
        });
    });
}

function comment(post_id) {
    $(`#commentBoxContainer-${post_id}`).toggleClass("d-none");
    $(`#comment-${post_id}`).focus();
}

function editComment(comment_id) {
    let commentText = $(`#nested_comment-${comment_id}`);

    if (comment_id == null) {
        alert("Comment id do not exists");
        return;
    }

    $.ajax({
        url: `posts/comment/show/${comment_id}`,
        method: "GET",
        success: (res) => {
            if (!res.success) {
                error_message(res.message);
                return;
            }
            $(`#nested_commentContainer-${comment_id}`).toggleClass("d-none");
            commentText.val(res.data.comment);
        },
    });
}

function updateComment(comment_id) {
    let commentText = $(`#nested_comment-${comment_id}`).val();

    $.ajax({
        url: `posts/comment/update`,
        method: "POST",
        data: {
            commentText: commentText,
            comment_id: comment_id,
        },
        success: (res) => {
            renderPost();
            commentText.val("");
            $(`#nested_commentContainer-${comment_id}`).toggleClass("d-none");
        },
    });
}
