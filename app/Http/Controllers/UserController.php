<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexEmployee()
    {
        $data = Employee::all();
        if ($data->count() >= 1) {
            return response()->json([
                'success' => true,
                'message' => 'All Employee Retrieve Successfully',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found'
        ], 500);
    }
}
