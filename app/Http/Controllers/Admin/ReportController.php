<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view("Admin.pages.report.index");
    }

    public function dataTable(Request $request)
    {
        $ajaxData = dataTableRequests($request->all());

        // Total records
        $query = Expense::with('paymentMethod', 'currency', 'expenseCategory');
        $totalRecords = $query->count();

        // Search filter
        if (!empty($ajaxData['searchValue'])) {
            $query->where('name', 'like', '%' . $ajaxData['searchValue'] . '%');
        }
        $totalRecordswithFilter = $query->count();

        $records = $query->orderBy('id', 'DESC')
            ->skip($ajaxData['start'])
            ->take($ajaxData['rowperpage'])
            ->get();

        $data_arr = [];
        $sl = 1;
        foreach ($records as $record) {
            $button = "";

            $button .= '<a href="javascript:void(0);" class="link-primary fs-14" onclick="right_canvas(\'' . route('admin.edit', encrypt($record->id)) . '\')"><i class="ri-edit-2-line"></i></a>';
            $button .= '<a href="javascript:void(0);" class="link-danger mx-2 mt-2 fs-14" onclick="cofirm_modal(\'' . route('admin.delete', encrypt($record->id)) . '\', \'' . "datatable" . '\')"><i class="ri-delete-bin-2-line"></i></a>';

            $data_arr[] = [
                "sl" => $sl,
                "payment_method_id" => $record->paymentMethod->title,
                "currency_id" => $record->currency->title,
                "expense_category_id" => $record->expenseCategory->title,
                "merchant_name" => $record->merchant_name,
                "date_of_spend" => $record->date_of_spend,
                "amount_spent" => $record->amount_spent,
                "description" => $record->description,
                "attendees" => $record->attendees,
                "action" => $button
            ];
            $sl++;
        }

        $response = [
            "draw" => intval($ajaxData['draw']),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return response()->json($response);
    }

}
