/*
 * edit_model
 * */
function edit_model(url) {
    $.get(url, function (response) {
        $(".create_edit_modal_content").html(response);
        $(".create_edit_modal").modal("show");
    }).fail(function (error) {
        toastr(error.responseJSON.message, "bg-danger");
    });
}
