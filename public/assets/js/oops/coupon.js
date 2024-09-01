import { Server } from "./server.js";
import { FileUpload } from "./file_upload.js";
import { Helper } from "./helper.js";

export class Coupon {
    constructor() {
        this.server = new Server();
        this.file_upload = new FileUpload();
        this.helper = new Helper();
    }

    /**
     * storeCoupon
     * @param {*} url
     * @param {*} formData
     */
    storeCoupon(url, formData) {
        this.helper.buttonDisable("save_coupon_button"); // call helper function
        this.file_upload
            .request(url, "POST", formData)
            .done((response, statusText, xhr) => {
                if (xhr.status == 201) {
                    $("#add_coupon")[0].reset();

                    $(".invalid-feedback").text("");
                    $(".form-control").removeClass("is-invalid");

                    const coupon_default_image_url =
                        window.location.origin +
                        "/" +
                        "assets/application/images/coupon/coupon-default-image.jpg";
                    $("#viewer").attr("src", coupon_default_image_url);
                    $("#coupon_description").val("");
                    $("#coupon_datatable").DataTable().ajax.reload();
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
                this.helper.buttonEnable("save_coupon_button", "submit");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("save_coupon_button", "submit");

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
     * couponDatatable
     * @param {*} url
     */
    couponDatatable(url) {
        $("#coupon_datatable").DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Vendor / Coupon code",
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
                    data.searchByStatus = $("#filter_by_status").val();
                },
                beforeSend: () => {
                    // Here, manually add the loading message.
                    this.helper.dataTableLoadingMessage("coupon_datatable");
                },
            },
            columns: [
                {
                    data: "sl",
                },
                {
                    data: "coupon_image",
                },
                {
                    data: "vendor_name",
                },
                {
                    data: "coupon_code",
                },
                {
                    data: "coupon_title",
                },
                {
                    data: "minimum_purchase",
                },
                {
                    data: "discount",
                },
                {
                    data: "access",
                },
                {
                    data: "coupon_per_user",
                },
                {
                    data: "discount_type",
                },
                {
                    data: "expiry_date",
                },
                {
                    data: "status",
                },
                {
                    data: "action",
                },
            ],
            drawCallback: () => {
                $(".coupon_status").on("click", async (e) => {
                    try {
                        let status =
                            $(e.target).prop("checked") === true ? 1 : 0;

                        let coupon_id = $(e.target).data("id");
                        let url = $(e.target).data("url");

                        let data = {
                            status: status,
                            coupon_id: coupon_id,
                        };
                        var result = await this.updateCouponStatus(url, data);
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
     * updateCouponStatus
     * @param {*} url
     * @param {*} data
     * @returns
     */
    updateCouponStatus(url, data) {
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
     * updateCoupon
     * @param {*} url
     * @param {*} formData
     */
    updateCoupon(url, formData) {
        this.helper.buttonDisable("update_coupon_button"); // call helper function
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
                this.helper.buttonEnable("update_coupon_button", "update");
            })
            .fail((error) => {
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");

                this.helper.buttonEnable("update_coupon_button", "update");

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
