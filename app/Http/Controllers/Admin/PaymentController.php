<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        return view("Admin.pages.payment_method.index");
    }

    public function store(Request $request)
    {
        $rules = [
            'payment_type' => ['required'],
            'payment_name' => ['required', 'string', 'max:200'],
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'user_id' => Auth::id(),
            'title' => $request->payment_type,
            'payment_name' => $request->payment_name,
        ];

        $save = PaymentMethod::create($data);

        if ($save) {
            return response()->json(['message' => 'Created successfully!'], 201);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }

    public function dataTable(Request $request)
    {
        $ajaxData = dataTableRequests($request->all());

        $userId = auth()->id();

        $query = PaymentMethod::where('user_id', $userId);
        $totalRecords = $query->count();

        if (!empty($ajaxData['searchValue'])) {
            $query->where('title', 'like', '%' . $ajaxData['searchValue'] . '%');
        }
        $totalRecordswithFilter = $query->count();

        $records = $query->orderBy('id', 'DESC')
            ->skip($ajaxData['start'])
            ->take($ajaxData['rowperpage'])
            ->get();

        $data_arr = array();
        $sl = 1;
        foreach ($records as $record) {

            $button = "";

            $button .= '<a href="javascript:void(0);" class="link-primary fs-18" onclick="right_canvas(\'' . route('user.payment.edit', encrypt($record->id)) . '\')"><i class="ri-edit-2-line"></i></a>';
            $button .= '<button class="link-danger mx-2 mt-2 fs-18" onclick="confirm_modal(\'' . route('user.payment.delete', encrypt($record->id)) . '\', \'' . "datatable" . '\')" disabled><i class="ri-delete-bin-2-line"></i></button>';

            $formattedPaymentName = ucwords(str_replace('_', ' ', $record->title));
            
            $data_arr[] = array(
                "sl" => $sl,
                "title" => $formattedPaymentName,
                "payment_name" => $record->payment_name,
                "action" => $button
            );
            $sl++;
        }

        $response = array(
            "draw" => intval($ajaxData['draw']),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function edit($id)
    {
        $payments = PaymentMethod::where('id', decrypt($id))->get();
        $paymentMethods = PaymentMethod::where('id', decrypt($id))->first();

        return view('Admin.pages.payment_method.edit', compact('paymentMethods', 'payments'));
    }
    
    public function update(Request $request)
    {
        $payment_id = decrypt($request->payment_id);

        $payment = PaymentMethod::find($payment_id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found!'], 404);
        }

        $rules = [
            'payment_type' => ['required'],
            'payment_name' => ['required', 'string', 'max:200'],
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'title' => $request->payment_type,
            'payment_name' => $request->payment_name,
        ];

        $update_user = $payment->update($data);

        if (!$update_user) {
            return response()->json(['message' => 'Something went wrong while updating the user!'], 500);
        }

        return response()->json(['message' => 'Payment Method updated successfully!'], 200);
    }


    public function delete($id)
    {
        $id = decrypt($id);

        $delete = PaymentMethod::where('id', $id)->delete();

        if (!$delete)
            return response()->json(['message' => 'Something went wrong!'], 500);


        return response()->json(['message' => 'Payment Method deleted successfully!'], 200);
    }
}
