function error_message(msg="") {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: msg,
    });
}

function success_message(msg="") {
    Swal.fire({
        position: "top-center",
        icon: "success",
        title: msg,
        showConfirmButton: false,
        timer: 1500,
    });
}

