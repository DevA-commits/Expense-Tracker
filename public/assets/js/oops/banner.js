import { Server } from "./server.js";
import { FileUpload } from "./file_upload.js";
import { Helper } from "./helper.js";

export class Banner {
    constructor() {
        this.server = new Server();
        this.file_upload = new FileUpload();
        this.helper = new Helper();
    }

    /**
     * vendorBannerCategory
     * @param {*} url
     * @param {*} data
     */
    vendorBannerCategory(url, data) {
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
                    $("#banner_category").html(html);
                }
            })
            .fail((error) => {
                console.log(error);
            });
    }

    /**
     * storeBanner
     * @param {*} url
     * @param {*} formData
     */
    storeBanner(url, formData) {
        this.helper.buttonDisable("save_banner_button"); // call helper function
        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 201) {
                    $("#add_banner")[0].reset();

                    $(".invalid-feedback").text("");
                    $(".form-control").removeClass("is-invalid");

                    const banner_default_image_url =
                        window.location.origin +
                        "/" +
                        "assets/application/images/banner/banner-default-image.jpg";
                    $("#viewer").attr("src", banner_default_image_url);
                    $("#banner_datatable").DataTable().ajax.reload();
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
                this.helper.buttonEnable("save_banner_button", "submit");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("save_banner_button", "submit");

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
     * bannerDatatable
     * @param {*} url
     */
    bannerDatatable(url) {
        $("#banner_datatable").DataTable({
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
                data: function (data) {
                    data.searchByAdmin = $("#filter_by_admin").is(":checked")
                        ? "Admin"
                        : "";
                    data.searchByUnclickable = $("#filter_by_unclickable").is(
                        ":checked"
                    )
                        ? "Unclickable"
                        : "";
                    data.searchByStatus = $("#filter_by_status").val();
                },
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
                    data: "banner_image",
                },
                {
                    data: "vendor_name",
                },
                {
                    data: "category_name",
                },
                {
                    data: "platform",
                },
                {
                    data: "status",
                },
                {
                    data: "action",
                },
            ],
            drawCallback: () => {
                $(".banner_status").on("click", async (e) => {
                    try {
                        let status =
                            $(e.target).prop("checked") === true ? 1 : 0;

                        let banner_id = $(e.target).data("id");
                        let url = $(e.target).data("url");

                        let data = {
                            status: status,
                            banner_id: banner_id,
                        };
                        var result = await this.updateBannerStatus(url, data);
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
     * updateBannerStatus
     * @param {*} url
     * @param {*} data
     * @returns
     */
    updateBannerStatus(url, data) {
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
     * updateBanner
     * @param {*} url
     * @param {*} formData
     */
    updateBanner(url, formData) {
        this.helper.buttonDisable("update_banner_button"); // call helper function
        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 200) {
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
                this.helper.buttonEnable("update_banner_button", "update");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("update_banner_button", "update");

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
