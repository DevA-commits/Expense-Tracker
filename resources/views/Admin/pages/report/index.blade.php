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
                <div class="bg-dark text-white d-flex align-items-center gap-4">
                    <div class="p-2">
                        <div class="card-header bg-primary fw-bold p-1 px-4">
                            Total Balance Amount - {{ $totalAmount ? $totalAmount->amount : 'N/A' }}
                        </div>
                    </div>
                    <div class="p-2">
                        <div class="card-header bg-warning fw-bold p-1 px-4 text-dark">
                            Expense Amount -
                            {{ $totalSpent == floor($totalSpent) ? number_format($totalSpent, 0) : number_format($totalSpent, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Manage Report</h4>
                            <input class="b-2 p-2" id="monthPicker" type="month" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table table-warning table-striped">
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

        document.addEventListener("DOMContentLoaded", function () {
            const monthPicker = document.getElementById("monthPicker");
            const now = new Date();
            const month = now.toISOString().slice(0, 7); // YYYY-MM format
            monthPicker.value = month;
        });

        $(document).ready(function () {
            const monthPicker = document.getElementById("monthPicker");

            function loadDataTable(month) {
                $("#datatable").DataTable({
                    responsive: true,
                    destroy: true, // Destroy previous initialization
                    language: {
                        searchPlaceholder: "",
                    },
                    ordering: false,
                    processing: false,
                    serverSide: true,
                    serverMethod: "POST",
                    ajax: {
                        url: "{{ route('admin.datatable') }}",
                        data: {
                            month: month // Pass the selected month
                        },
                        beforeSend: () => {
                            // Here, manually add the loading message.
                            $("#datatable > tbody").html(
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
                    }, {
                        data: "action",
                    }],
                });
            }

            // Initialize the DataTable with the current month
            loadDataTable(monthPicker.value);

            // Reload the DataTable when the month changes
            monthPicker.addEventListener('change', function () {
                loadDataTable(this.value);
            });
        });

    </script>
@endpush