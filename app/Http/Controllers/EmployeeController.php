<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function all()
    {
        $employees = Employee::all();

        return response()->json([
            'success' => true,
            'body' => $employees
        ], 200);
    }

    public function delete($id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted from database',
                'body' => ['id' => $id]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), Employee::$updateRules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'body' => [$validator->errors()]
            ], 422);
        }

        $validatedData = $validator->validated();

        $updateData = array_diff_assoc($validatedData, $employee->toArray());

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'No new data provided'
            ], 422);
        }

        $employee->update($updateData);

        $updatedEmployee = $employee->fresh();

        return response()->json([
            'success' => true,
            'message' => 'Employee successfully updated',
            'body' => $updatedEmployee
        ], 200);
    }

    public function new(Request $request)
    {
        $validator = Validator::make($request->all(), Employee::$rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'body' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $employee = Employee::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Employee added to the database',
            'body' => $employee
        ], 201);
    }
}
