import { Server } from "./server.js";
import { FileUpload } from "./file_upload.js";
import { Helper } from "./helper.js";

export class Category {
    constructor() {
        this.server = new Server();
        this.file_upload = new FileUpload();
        this.helper = new Helper();
    }

    /**
     * storeCategory
     * @param {*} url
     * @param {*} formData
     */
    storeCategory(url, formData) {
        this.helper.buttonDisable("save_category_button"); // call helper function

        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 201) {
                    $("#add_category")[0].reset();

                    $(".invalid-feedback").text("");
                    $(".form-control").removeClass("is-invalid");

                    $("#category_bg_color").val("#008938");
                    const cat_default_image_url =
                        window.location.origin +
                        "/" +
                        "assets/application/images/category/category-default-image.png";
                    $("#viewer").attr("src", cat_default_image_url);
                    $("#category_datatable").DataTable().ajax.reload();
                    VRToastr(
                        response.message,
                        "bg-success",
                        "",
                        "",
                        "",
                        "",
                        ""
                    );
                } else {
                    VRToastr(
                        response.message,
                        "bg-success",
                        "",
                        "",
                        "",
                        "",
                        ""
                    );
                }
                this.helper.buttonEnable("save_category_button", "submit");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("save_category_button", "submit");

                if (error.status == 422) {
                    $.each(error.responseJSON, function (key, val) {
                        $("#" + key).addClass("is-invalid");
                        $("#" + key + "_error").text(val[0]);
                    });
                } else {
                    VRToastr(
                        error.responseJSON.message,
                        "bg-danger",
                        "",
                        "",
                        "",
                        "",
                        ""
                    );
                }
            });
    }

    /**
     * categoryDatatable
     * @param {*} url
     */

    categoryDatatable(url) {
        $("#category_datatable").DataTable({
            responsive: true,
            language: {},
            ordering: false,
            processing: false,
            serverSide: true,
            serverMethod: "POST",
            ajax: {
                url: url,
                beforeSend: () => {
                    // Here, manually add the loading message.
                    this.helper.dataTableLoadingMessage("category_datatable");
                },
            },
            columns: [
                {
                    data: "sl",
                },
                {
                    data: "name",
                },
                {
                    data: "status",
                },
                {
                    data: "offer_content",
                },
                {
                    data: "action",
                },
            ],
            drawCallback: () => {
                $(".form-check-input").on("click", async (e) => {
                    try {
                        let status =
                            $(e.target).prop("checked") === true ? 1 : 0;
                        let category_id = $(e.target).data("id");
                        let url = $(e.target).data("url");

                        let data = {
                            status: status,
                            category_id: category_id,
                        };
                        var result = await this.updateCategoryStatus(url, data);
                        VRToastr(result, "bg-success", "", "", "", "", "");
                    } catch (error) {
                        var checkBoxes = $(e.target);
                        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
                        VRToastr(error, "bg-danger", "", "", "", "", "");
                    }
                });
            },
        });
    }
    /**
     * updateCategoryStatus
     * @param {*} url
     * @param {*} data
     * @return Promise
     */
    updateCategoryStatus(url, data) {
        return new Promise((resolve, reject) => {
            this.server
                .request(url, "POST", data)
                .done((response, statusText, xhr) => {
                    resolve(response.message);
                })
                .fail((error) => {
                    reject(error.responseJSON.message);
                });
        });
    }

    /**
     * updateCategory
     * @param {*} url
     * @param {*} formData
     */
    updateCategory(url, formData) {
        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 200) {
                    $(".invalid-feedback").text("");
                    $(".form-control").removeClass("is-invalid");
                    $(".create_edit_modal").modal("hide");
                    $("#category_datatable").DataTable().ajax.reload();

                    VRToastr(
                        response.message,
                        "bg-success",
                        "",
                        "",
                        "",
                        "",
                        ""
                    );
                }
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");
                if (error.status == 422) {
                    $.each(error.responseJSON, function (key, val) {
                        $("#" + key).addClass("is-invalid");
                        $("#" + key + "_error").text(val[0]);
                    });
                } else {
                    VRToastr(
                        error.responseJSON.message,
                        "bg-danger",
                        "",
                        "",
                        "",
                        "",
                        ""
                    );
                }
            });
    }
}
