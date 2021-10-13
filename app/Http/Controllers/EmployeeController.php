<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Category, Employee, Hobby;
use Exception;
use Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Used to load employee table.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadEmployeesTable() {
        $employees = Employee::with('category:category_id,name', 'hobbies:hobby_id,name')
            ->get();
        $hobbies = Hobby::select('hobby_id','name')->get();
        $categories = Category::select('category_id','name')->get();
        return view('employee_list', [
                'employees' => $employees,
                'hobbies' => $hobbies,
                'categories' => $categories
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hobbies = Hobby::select('hobby_id','name')->get();
        $categories = Category::select('category_id','name')->get();
        return view('employee_modal', [
                'hobbies' => $hobbies,
                'categories' => $categories
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('hobbies')) {
            $request->request->add(['employee_hobbies' => explode(",", $request->hobbies)]);
        }

        $success = false;
        $message = 'Fail to create the employee';

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact_no' => 'required|integer',
            'category' => 'required|exists:categories,category_id',
            'employee_hobbies' => 'required|exists:hobbies,hobby_id',
            'profile_pic' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'errors'  => $validator->errors()
            ]);
        }

        try {
            $file_name = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
            $file_path = $request->file('profile_pic')->storeAs('uploads', $file_name);

            $employee = new Employee;
            $employee->name = $request->name;
            $employee->contact_number = $request->contact_no;
            $employee->category_id = $request->category;
            $employee->image = $file_path;
            $employee->save();
            $employee->hobbies()->sync($request->employee_hobbies);
            $success = true;
            $message = 'Employee successfully created';
        } catch (Exception $e) {
            Log::error($message, $request->all());
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee_id)
    {
        $request->request->add(['employee_id' => $employee_id]);

        if ($request->has('hobbies')) {
            $request->request->add(['employee_hobbies' => explode(",", $request->hobbies)]);
        }

        $success = false;
        $message = 'Fail to update the employee';

        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,employee_id',
            'name' => 'required|string',
            'contact_no' => 'required|integer',
            'category' => 'required|exists:categories,category_id',
            'employee_hobbies' => 'required|exists:hobbies,hobby_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'errors'  => $validator->errors()
            ]);
        }

        $last_image = null;

        try {
            $employee = Employee::find($employee_id);
            $employee->name = $request->name;
            $employee->contact_number = $request->contact_no;
            $employee->category_id = $request->category;

            if ($request->hasFile('profile_pic')) {
                $last_image = $employee->getRawOriginal('image');
                $file_name = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $file_path = $request->file('profile_pic')->storeAs('uploads', $file_name);
                $employee->image = $file_path;
            }
            $employee->save();
            $employee->hobbies()->sync($request->employee_hobbies);
            
            if ($last_image) {
                \Storage::disk(config('filesystems.default'))->delete($last_image);
            }

            $success = true;
            $message = 'Employee successfully updated';
        } catch (Exception $e) {
            Log::error($message, $request->all());
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Remove a set of resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request) 
    {
        $success = false;
        $message = 'Fail to delete the employees';

        $validator = Validator::make($request->all(), [
            'employee_ids' => 'required|exists:employees,employee_id',
        ]);

        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                foreach ($request->employee_ids as $employee_id) {
                    $employee = Employee::find($employee_id);
                    $employee->delete();
                }

                DB::commit();
                $success = true;
                $message = 'Employees deleted successfully';

            } catch (Exception $e) {
                DB::rollBack();
                Log::error($message, $request->all());
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
