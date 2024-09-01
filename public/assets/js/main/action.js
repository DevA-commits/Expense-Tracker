
/**
 * Get respective data
 */
function drodown(url, tableid, inputid) {
    $.ajax({
        url: url
        , method: 'POST'
        , data: {
            id: tableid
        },
    }).done((response) => {
        var html = '<option value="">--SELECT--</option>';
        $.each(response.data, function (key, val) {
            html += '<option value="' + val.id + '">' + val.value + '</option>';
        });
        $('#' + inputid).html(html);

    }).fail((error) => {
        console.log(error);
    });

}