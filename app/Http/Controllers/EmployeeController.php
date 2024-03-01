<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // dd($request->all());
       $validatedData = $request->validate([
            "name"=> "required",
            "address"=>"required",
            "phoneNo"=> "required",
            "dateOfBirth"=>["required","date"],
        ]);
        $employee = Employee::create($validatedData);
        return $this->successResponse(["Employee created successfully",
            $employee,200]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
        $employee = Employee::findOrFail($id);
        // dd($request->all());
        // $employee->name = $request->name;
        $employee->update($request->all());
        return $this->successResponse(
            "Employee updated successfully",
             $employee);
        } catch (\Exception $e) {
            return $this->errorResponse(
                 "Error updating employee",
                 $e->getMessage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json($employee,200);

    }
}
