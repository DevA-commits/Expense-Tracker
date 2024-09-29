@extends('Admin.layouts.main')
@section('title', 'EXPENSE | CREATE')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Expense</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="javascript: void(0);">Expense</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Expense</li>
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
                        <h4 class="card-title">Create Expense</h4>
                    </div>
                    <div class="card-body">
                        <form id="save" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="required">Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <option value="">--Select Option--</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}">
                                                    {{ ucwords(str_replace('_', ' ', $paymentMethod->title)) }} - ({{ $paymentMethod->payment_name}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" id="payment_method_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="merchant_name" class="required">Merchant Name</label>
                                        <input type="text" name="merchant_name" id="merchant_name" class="form-control"
                                            placeholder="Enter merchant name">
                                        <span class="invalid-feedback" id="merchant_name_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="date_of_spend" class="required">Date of Spend</label>
                                        <input type="date" name="date_of_spend" id="date_of_spend" class="form-control"
                                            value="{{ date('Y-m-d') }}">
                                        <span class="invalid-feedback" id="date_of_spend_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="currency" class="required">Currency</label>
                                        <select name="currency" id="currency" class="form-control">
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" id="currency_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="amount_spent" class="required">Amount Spent</label>
                                        <input type="number" name="amount_spent" id="amount_spent" class="form-control"
                                            placeholder="Enter amount spent">
                                        <span class="invalid-feedback" id="amount_spent_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="expense_category" class="required">Category</label>
                                        <select name="expense_category" id="expense_category" class="form-control">
                                            <option value="">--Select Option--</option>
                                            @foreach ($expensecategories as $expensecategory)
                                                <option value="{{ $expensecategory->id }}">{{ $expensecategory->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" id="expense_category_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="description" class="required">Description</label>
                                        <textarea name="description" id="description" class="form-control"
                                            placeholder="Enter description"></textarea>
                                        <span class="invalid-feedback" id="description_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="attendees" class="required">Attendees (comma-separated)</label>
                                        <input type="text" name="attendees" id="attendees" class="form-control"
                                            placeholder="Enter attendees (comma-separated)" value="Myself, ">
                                        <span class="invalid-feedback" id="attendees_error"></span>
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
                            <h4 class="card-title">Most Recently Added Expense Details</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table table-light table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payment Method</th>
                                        <th>Merchant Name</th>
                                        <th>Date Of Spend</th>
                                        <!-- <th>Currency</th> -->
                                        <th>Expense Category</th>
                                        <th class="bg-danger text-white">Amount Spent</th>
                                        <!-- <th>Note</th> -->
                                        <!-- <th>Attendees</th> -->
                                        <!-- <th>Action</th> -->
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
                url: "{{ route('admin.store') }}",
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
                url: "{{ route('admin.table.datatable') }}",
                beforeSend: () => {
                    // Here, manually add the loading message.
                    $("#banks_datatable > tbody").html(
                        '<tr class="odd">' +
                        '<td valign="top" colspan="7" class="dataTables_empty">Loading&hellip;</td>' +
                        "</tr>"
                    );
                },
            },
            columns: [{
                data: "sl",
            }, {
                data: "payment_method_id",
            }, {
                data: "merchant_name",
            }, {
                data: "date_of_spend",
            }, {
                data: "expense_category_id",
            }, {
                data: "amount_spent",
            }],
        });
    </script>
@endpush