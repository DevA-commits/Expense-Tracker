const defaultValues = {
    className: "bg-success",
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "right", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
};

function toastr(text, className) {
    Toastify({
        text: text,
        className: className == "" ? defaultValues.className : className,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
    }).showToast();
}

// VRToastr('Product category added successfully!', 'bg-success', '', '', '', '', '');
