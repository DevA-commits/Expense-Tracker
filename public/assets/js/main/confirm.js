function cofirm_modal(url, refresh_table_name) {
    $("#confirm_url").val(url);
    $("#refresh_table_name").val(refresh_table_name);
    $("#confirm-modal").modal("show");
}

function confirmData() {
    var url = $("#confirm_url").val();
    var refresh_table_name = $("#refresh_table_name").val();

    $.ajax({
        url: url,
        method: "POST",
    })
        .done((response) => {
            $("#" + refresh_table_name)
                .DataTable()
                .ajax.reload(null, false);
            $("#confirm-modal").modal("hide");
            toastr(response.message, "bg-success");
        })
        .fail((error) => {
            $("#confirm-modal").modal("hide");
            toastr(error.responseJSON.message, "bg-danger");
            ``;
        });
}
