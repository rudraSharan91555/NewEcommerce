<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Traits\ApiResponse;

class sizeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = Size::get();
        return view('admin/Size/size', get_defined_vars());
    }

    public function store(Request $request)
{
    $validation = Validator::make($request->all(), [
        'text' => 'required|string|max:255',
        'id'   => 'nullable|integer',
    ]);

    if ($validation->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validation->errors()->first()
        ], 400);
    }

    Size::updateOrCreate(
        ['id' => $request->id],
        ['text' => $request->text]
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Successfully updated',
        'reload' => true
    ]);
}

}