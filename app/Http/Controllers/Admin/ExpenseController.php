<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Expence;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::get();
        $currencies = Currency::get();
        $expensecategories = ExpenseCategory::get();

        return view('Admin.pages.expanse.index', compact('paymentMethods', 'currencies', 'expensecategories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'payment_method' => 'required|exists:payment_methods,id',
            'merchant_name' => 'required|string|max:255',
            'date_of_spend' => 'required|date',
            'currency' => 'required|exists:currencies,id',
            'amount_spent' => 'required|numeric|min:0',
            'expense_category' => 'required|exists:expense_categories,id',
            'description' => 'required|string|max:400',
            'attendees' => 'nullable|string',
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'payment_method_id' => $request->payment_method,
            'merchant_name' => $request->merchant_name,
            'date_of_spend' => $request->date_of_spend,
            'currency_id' => $request->currency,
            'amount_spent' => $request->amount_spent,
            'expense_category_id' => $request->expense_category,
            'description' => $request->description,
            'attendees' => $request->attendees,
        ];

        $save = Expense::create($data);

        if ($save) {
            return response()->json(['message' => 'Created successfully!'], 201);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }
}
