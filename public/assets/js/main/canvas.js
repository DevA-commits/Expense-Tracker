function right_canvas(url) {
    $.get(url, function (response) {
        $(".right_canvas").html(response);

        var myOffcanvas = document.getElementById("offcanvasRight");
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
        bsOffcanvas.show();
    }).fail(function (error) {
        toastr(error.responseJSON.message, "bg-danger");
    });
}

function top_canvas(url) {
    $.get(url, function (response) {
        $(".top_canvas").html(response);
        var myOffcanvas = document.getElementById("offcanvasTop");
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
        bsOffcanvas.show();
    }).fail(function (error) {
        toastr(error.responseJSON.message, "bg-danger");
    });
}
