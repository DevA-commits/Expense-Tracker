function right_canvas(url) {
    $.get(url, function (response) {
        $(".right_canvas").html(response);

        var myOffcanvas = document.getElementById("offcanvasRight");
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
        bsOffcanvas.show();
    });
}
