@extends('Admin.layouts.main')
@section('title', 'EXPENSE | REPORT')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">Manage Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payment Method</th>
                                        <th>Merchant Name</th>
                                        <th>Date Of Spend</th>
                                        <th>Currency</th>
                                        <th class="bg-danger text-white">Amount Spent</th>
                                        <th>Expense Category</th>
                                        <th>Note</th>
                                        <th>Attendees</th>
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
                url: "{{ route('admin.datatable') }}",
                beforeSend: () => {
                    // Here, manually add the loading message.
                    $("#banks_datatable > tbody").html(
                        '<tr class="odd">' +
                        '<td valign="top" colspan="5" class="dataTables_empty">Loading&hellip;</td>' +
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
                data: "currency_id",
            }, {
                data: "amount_spent",
            }, {
                data: "expense_category_id",
            }, {
                data: "description",
            }, {
                data: "attendees",
            }, {
                data: "action",
            },
            ],
        });
    </script>
@endpush