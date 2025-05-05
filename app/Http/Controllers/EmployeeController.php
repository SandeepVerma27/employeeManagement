<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No employees found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Employees retrieved successfully.',
            'data' => $employees
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|unique:employees',
            'name'        => 'required|string',
            'email'       => 'required|email|unique:employees',
            'dob'         => 'required|date',
            'doj'         => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $employee = Employee::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully.',
                'data'    => $employee
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create employee.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Employee retrieved successfully.',
                'data'    => $employee
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'employee_id' => [
                    'required',
                    Rule::unique('employees')->ignore($employee->id),
                ],
                'name'  => 'required|string',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('employees')->ignore($employee->id),
                ],
                'dob'   => 'required|date',
                'doj'   => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $employee->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully.',
                'data'    => $employee
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating employee.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting employee.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
