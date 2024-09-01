import { Server } from "./server.js";
import { FileUpload } from "./file_upload.js";
import { Helper } from "./helper.js";

export class Product {
    constructor() {
        this.server = new Server();
        this.file_upload = new FileUpload();
        this.helper = new Helper();
    }

    /**
     * storeProduct
     * @param {*} url
     * @param {*} formData
     */
    storeProduct(url, formData) {
        this.helper.buttonDisable("save_product_button"); // call helper function
        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 201) {
                    $("#add_product")[0].reset();

                    $(".invalid-feedback").text("");
                    $(".form-control").removeClass("is-invalid");
                    $("#vendor_name").val("").change();
                    $("#product_list").DataTable().ajax.reload();
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
                this.helper.buttonEnable("save_product_button", "submit");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("save_product_button", "submit");

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
     * productDatatable
     * @param {*} url
     */
    productDatatable(url) {
        $("#product_list").DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Vendor / Category name",
            },
            ordering: false,
            processing: false,
            serverSide: true,
            serverMethod: "POST",
            ajax: {
                url: url,
                data: function (data) {},
                beforeSend: () => {
                    // Here, manually add the loading message.
                    this.helper.dataTableLoadingMessage("banner_datatable");
                },
            },
            columns: [
                {
                    data: "sl",
                },
                {
                    data: "product_image",
                },
                {
                    data: "product_name",
                },
                {
                    data: "status",
                },
                {
                    data: "action",
                },
            ],
            drawCallback: () => {
                $(".product_status").on("click", async (e) => {
                    try {
                        let status =
                            $(e.target).prop("checked") === true ? 1 : 0;
                        let product_id = $(e.target).data("id");
                        let url = $(e.target).data("url");
                        let data = {
                            status: status,
                            product_id: product_id,
                        };
                        var result = await this.updateProductStatus(url, data);
                        VRToastr(result, "bg-success", "", "", "", "", "");
                    } catch (error) {
                        var checkBoxes = $(e.target);
                        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
                        VRToastr(error, "bg-danger", "", "", "", "", "");
                    }
                });
            },
        });
        $("#product_list_filter").css("display", "none"); // hidden search input
    }

    /**
     * updateProductStatus
     * @param {*} url
     * @param {*} data
     * @returns
     */
    updateProductStatus(url, data) {
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
}
