import { Server } from "./server.js";
export class Helper {
    constructor() {
        this.server = new Server();
    }
    /**
     * buttonDisable
     * @param {*} button_id
     */
    buttonDisable(button_id) {
        $("#" + button_id).attr("disabled", true);
        $("#" + button_id).html(window.spinner);
    }

    /**
     * buttonEnable
     * @param {*} button_id
     * @param {*} button_text
     */
    buttonEnable(button_id, button_text) {
        $("#" + button_id).removeAttr("disabled");
        $("#" + button_id).html(button_text);
    }

    /**
     * dataTableLoadingMessage
     * @param {*} table_id
     */
    dataTableLoadingMessage(table_id) {
        $("#" + table_id + " > tbody").html(
            '<tr class="odd">' +
                '<td valign="top" colspan="6" class="dataTables_empty">Loading&hellip;</td>' +
                "</tr>"
        );
    }

    /**
     * vendorCategory
     * @param {*} url
     * @param {*} data
     * @param {*} input_id
     */
    vendorCategory(url, data, input_id) {
        this.server
            .request(url, "POST", data)
            .done((response, statusText, xhr) => {
                if (xhr.status == 200) {
                    var html = '<option value="">--SELECT--</option>';
                    $.each(response.data, function (key, val) {
                        if (val != null) {
                            html +=
                                '<option value="' +
                                val.id +
                                '">' +
                                val.cat_name +
                                "</option>";
                        }
                    });
                    $("#" + input_id).html(html);
                }
            })
            .fail((error) => {
                console.log(error);
            });
    }
}
