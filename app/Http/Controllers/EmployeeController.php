<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
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


    /* Only Admin can created */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'dob' => 'required|date',
            'doj' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'error' => $validator->errors()
            ], 412);
        }

        $data = $validator->validate();
        $employee = Employee::create($data);

        if ($employee) {
            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully',
                'data' => $employee
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not created !'
        ], 500);
    }

    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Employee retrieved successfully',
                'data'    => $employee
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id); // First fetch the record

        $validator = Validator::make($request->all(), [
            'employee_id' => [
                'required',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'dob' => 'required|date',
            'doj' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 412);
        }

        $data = $validator->validated();

        $employee->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting employee',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
