@extends('Admin.layouts.main')
@section('title', 'ADD PAYMENT METHOD | CREATE')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Payment Method</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payment Method</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Payment Method</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h4 class="card-title">Create Payment Method</h4>
                    </div>
                    <div class="card-body">
                        <form id="save" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_type" class="required">Payment Method Type</label>
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value="">--Select Payment Option--</option>
                                            <option value="upi">UPI</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="debit_card">Debit Card</option>
                                            <option value="cash">Cash</option>
                                            <option value="bank_transfer">Bank Transfer (NEFT, RTGS, IMPS)</option>
                                            <option value="mobile_wallet">Mobile Wallet (Paytm, Google Pay, etc.)
                                            </option>
                                            <option value="net_banking">Net Banking</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="prepaid_card">Prepaid Card</option>
                                            <option value="emi">EMI (Equated Monthly Installments)</option>
                                            <option value="gift_card">Gift Card/Voucher</option>
                                            <option value="cryptocurrency">Cryptocurrency (e.g., Bitcoin, Ethereum)
                                            </option>
                                            <option value="paypal">PayPal</option>
                                            <option value="contactless_payment">Contactless Payment (Apple Pay, Google
                                                Pay)</option>
                                            <option value="pos_swipe">POS Swipe Machine</option>
                                            <option value="qr_code">QR Code Payment</option>
                                            <option value="demand_draft">Demand Draft (DD)</option>
                                        </select>
                                        <span class="invalid-feedback" id="payment_type_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_name" class="required">Payment / Nick Name</label>
                                        <input type="text" name="payment_name" id="payment_name" class="form-control"
                                            placeholder="Enter Bank / Payment Source Name For Reference">
                                        <span class="invalid-feedback" id="payment_name_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button id="save_btn" class="btn btn-success" type="submit">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Payment Method List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table table-light table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payment Method Type</th>
                                        <th>Paymant / Nick Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('modal')
@include('Admin._includes.offcanvas.right')
@include('Admin._includes.modals.delete_modal')
@endsection

@push('scripts')
    <script src="{{ url('assets/js/main/canvas.js') }}"></script>
    <script src="{{ url('assets/js/main/delete.js') }}"></script>

    <script>
        $('#save').submit(function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('user.payment.store') }}",
                method: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function () {
                    $('#save_btn').attr('disabled', true);
                    $('#save_btn').html(window.spinner);
                },
            }).done((response, statusText, xhr) => {
                $(".error-text").text("");
                $(".form-control").removeClass("is-invalid");
                $('#save_btn').removeAttr('disabled');
                $('#save_btn').html('Create');

                if (xhr.status == 201) {
                    $("#save")[0].reset();
                    $("#datatable").DataTable().ajax.reload();
                    toastr(response.message, "bg-success");
                }
                if (xhr.status == 200) {
                    toastr(response.message, "bg-success");
                }
            }).fail((error) => {
                $(".error-text").text("");
                $(".form-control").removeClass("is-invalid");
                $('#save_btn').removeAttr('disabled');
                $('#save_btn').html('Create');

                if (error.status == 422) {
                    $.each(error.responseJSON, function (key, val) {
                        $("#" + key).addClass("is-invalid");
                        $("#" + key + "_error").text(val[0]);
                    });
                } else {
                    toastr(error.responseJSON.message, "bg-danger");
                }
            });
        });


        $("#datatable").DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "",
            },
            ordering: false,
            processing: false,
            serverSide: true,
            serverMethod: "POST",
            ajax: {
                url: "{{ route('user.payment.datatable') }}",
                beforeSend: () => {
                    // Here, manually add the loading message.
                    $("#banks_datatable > tbody").html(
                        '<tr class="odd">' +
                        '<td valign="top" colspan="4" class="dataTables_empty">Loading&hellip;</td>' +
                        "</tr>"
                    );
                },
            },
            columns: [{
                data: "sl",
            }, {
                data: "title",
            }, {
                data: "payment_name",
            }, {
                data: "action",
            }],
        });
    </script>
@endpush