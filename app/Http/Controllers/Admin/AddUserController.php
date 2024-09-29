<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddUserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'You do not have access to this section.');
        }

        return view('Admin.pages.user.index');
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users,email'],
            'role' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8'],
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password), // Hash the password
            'role' => $request->role,
        ];

        $save = User::create($data);

        if ($save) {
            return response()->json(['message' => 'Created successfully!'], 201);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }

    public function edit($id)
    {
        $user = User::where('id', decrypt($id))->first();

        return view('Admin.pages.user.edit', compact('user'));
    }

    public function dataTable(Request $request)
    {
        $ajaxData = dataTableRequests($request->all());
        // Total records
        $query = User::query()->where('id', '!=', 1);
        $totalRecords = $query->count();

        // search filter
        if (!empty($ajaxData['searchValue'])) {
            $query->where('name', 'like', '%' . $ajaxData['searchValue'] . '%');
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

            $button .= '<a href="javascript:void(0);" class="link-primary fs-18" onclick="right_canvas(\'' . route('index.edit', encrypt($record->id)) . '\')"><i class="ri-edit-2-line"></i></a>';
            $button .= '<a href="javascript:void(0);" class="link-danger mx-2 mt-2 fs-18" onclick="cofirm_modal(\'' . route('index.delete', encrypt($record->id)) . '\', \'' . "datatable" . '\')"><i class="ri-delete-bin-2-line"></i></a>';

            $data_arr[] = array(
                "sl" => $sl,
                "name" => $record->name,
                "email" => $record->email,
                "role" => $record->role,
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

    public function update(Request $request)
    {
        $user_id = decrypt($request->user_id);

        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users,email,' . $user_id],
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user_data = [
            'email' => $request->email,
            'name' => $request->name,
        ];
    
        $update_user = $user->update($user_data);

        if (!$update_user) {
            return response()->json(['message' => 'Something went wrong while updating the user!'], 500);
        }

        return response()->json(['message' => 'User updated successfully!'], 200);
    }


    public function delete($id)
    {
        $id = decrypt($id);

        $delete = User::where('id', $id)->delete();

        if (!$delete)
            return response()->json(['message' => 'Something went wrong!'], 500);


        return response()->json(['message' => 'User deleted successfully!'], 200);
    }
}
