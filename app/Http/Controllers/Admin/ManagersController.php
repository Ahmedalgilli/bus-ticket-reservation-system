<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ManagersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }

        // $employees = User::all();

        if(Auth::user()->hasRole('manager')) {

            $employees = Auth::user()->employees;

            foreach ($employees as $employee) {
                if ($employee->roles()->first() == null) {
                    // dd($employees);
                    $employee->role = [];
                }else{
                    $employee->role = $employee->roles()->first();
                }
            }

            return Inertia::render('Managers/Index', [ 'employees' => $employees]);

        }
        

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }
        // $roles = Role::all();
        return Inertia::render('Managers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }
        Request::validate([
            'first_name' => ['required', 'max:25'],
            'last_name' => ['required', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data = [
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'remember_token' => Str::random(10),
            'owner' => false,
        ];

        $role = Role::find(3);

        if (Auth::user()->hasRole('manager')) {
            $user = Auth::user()->employees()->create($data);
            $user->save();
            $user->roles()->attach($role);

            return Redirect::route('managers.employees.index')->with('success', 'Employee created.');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(User $employee)
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(User $employee)
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }

        $roles = Role::all();

        // dd($employee);

        return Inertia::render('Managers/Edit', [
            'employee' => [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $employee)
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }
        Request::validate([
            'first_name' => ['required', 'max:25'],
            'last_name' => ['required', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required', 'string', 'min:8'],
        ]);

        $data = [
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'email' => Request::get('email'),
        ];

        if(Request::get('password') != null){
            $data['password'] = Request::get('password');
            $employee->update($data);
        }else{
            $employee->update($data);
        }

        $employee->save();

        return Redirect::route('managers.employees.index')->with('success', 'Employee Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $employee)
    {
        if (Gate::denies('manager-only')) {
            return redirect()->back();
        }
        $employee->roles()->detach();

        $employee->delete();

        return Redirect::route('managers.employees.index')->with('success', 'Employee Deleted.');
    }
}
