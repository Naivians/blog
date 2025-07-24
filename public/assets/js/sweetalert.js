function error_message(msg = "") {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: msg,
    });
}

function success_message(msg = "") {
    Swal.fire({
        position: "top-center",
        icon: "success",
        title: msg,
        showConfirmButton: false,
        timer: 1500,
    });
}

function deleteMessage(msg="") {
    Swal.fire({
        title: "Are you sure?",
        text: msg,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
            });
        }
    });
}
