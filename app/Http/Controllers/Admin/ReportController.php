<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\TotalAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        $totalAmount = TotalAmount::select('amount')->first();

        if (!$totalAmount) {
            return redirect()->back()->with('error', 'Total amount not found.');
        }

        $totalSpent = Expense::sum('amount_spent');

        $updatedAmount = $totalAmount->amount - $totalSpent;

        $totalAmount->amount = $updatedAmount;
        $totalAmount->update();

        return view("Admin.pages.report.index", [
            'totalAmount' => $totalAmount,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function list($id)
    {
        $list = Expense::where('id', decrypt($id))->first();
        return view('Admin.pages.report.list', compact('list'));
    }

    public function edit($id)
    {
        $expense = Expense::where('id', decrypt($id))->first();
        $paymentMethods = PaymentMethod::all();
        $currencies = Currency::all();
        $expenseCategories = ExpenseCategory::all();

        return view('Admin.pages.report.edit', compact('expense', 'paymentMethods', 'currencies', 'expenseCategories'));
    }


    public function update(Request $request)
    {
        $rules = [
            'merchant_name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:200'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'expense_category_id' => ['required', 'exists:expense_categories,id'],
            'date_of_spend' => ['required', 'date'],
            'amount_spent' => ['required', 'numeric', 'min:0'],
            'attendees' => ['nullable', 'string', 'max:500'],
        ];

        $messages = [
            // Custom error messages can be added here
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $expense_id = decrypt($request->expense_id);

        $expense = Expense::find($expense_id);
        if (!$expense) {
            return response()->json(['message' => 'Expense not found!'], 404);
        }

        $expense_data = [
            'merchant_name' => $request->merchant_name,
            'description' => $request->description,
            'payment_method_id' => $request->payment_method_id,
            'currency_id' => $request->currency_id,
            'expense_category_id' => $request->expense_category_id,
            'date_of_spend' => $request->date_of_spend,
            'amount_spent' => $request->amount_spent,
            'attendees' => $request->attendees,
        ];

        $update_expense = $expense->update($expense_data);

        if (!$update_expense) {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->json(['message' => 'Expense updated successfully!'], 200);
    }


    public function dataTable(Request $request)
    {
        $ajaxData = dataTableRequests($request->all());

        // Default to the current month if no month is provided
        $month = $request->get('month', date('Y-m'));
        $startOfMonth = $month . '-01';
        $endOfMonth = date("Y-m-t", strtotime($startOfMonth));

        // Total records
        $query = Expense::with('paymentMethod', 'currency', 'expenseCategory')
            ->whereBetween('date_of_spend', [$startOfMonth, $endOfMonth]);

        $totalRecords = $query->count();

        // Search filter
        if (!empty($ajaxData['searchValue'])) {
            $query->where(function ($q) use ($ajaxData) {
                $q->where('merchant_name', 'like', '%' . $ajaxData['searchValue'] . '%')
                    ->orWhereHas('paymentMethod', function ($q2) use ($ajaxData) {
                        $q2->where('title', 'like', '%' . $ajaxData['searchValue'] . '%');
                    })
                    ->orWhereHas('expenseCategory', function ($q2) use ($ajaxData) {
                        $q2->where('title', 'like', '%' . $ajaxData['searchValue'] . '%');
                    });
            });
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

            $button .= '<a href="javascript:void(0);" class="link-warning mx-2 mt-2 fs-14" onclick="right_canvas(\'' . route('admin.list', encrypt($record->id)) . '\')"><i class="ri-file-list-fill"></i></a>';
            $button .= '<a href="javascript:void(0);" class="link-danger mx-2 mt-2 fs-14" onclick="right_canvas(\'' . route('admin.edit', encrypt($record->id)) . '\')"><i class="ri-edit-2-line"></i></a>';
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
