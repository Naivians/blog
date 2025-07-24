$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#register").on("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = $(form).serialize();

    $(form).find('button[type="submit"]').prop("disabled", true);

    $.ajax({
        url: "/register",
        method: "POST",
        data: formData,
        success: (res) => {
            if (!res.success) {
                error_message(res.message);
                return
            }
            success_message(res.message)

            form.reset();
        },
        complete: function () {
            $(form).find('button[type="submit"]').prop("disabled", false);
        },
    });
});

$("#loginForm").on("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = $(form).serialize();

    $(form).find('button[type="submit"]').prop("disabled", true);

    $.ajax({
        url: "/",
        method: "POST",
        data: formData,
        success: (res) => {
            if (!res.success) {
                error_message(res.message);
                return
            }
            window.location.href = res.redirect
        },
        complete: function () {
            $(form).find('button[type="submit"]').prop("disabled", false);
        },
    });
});
