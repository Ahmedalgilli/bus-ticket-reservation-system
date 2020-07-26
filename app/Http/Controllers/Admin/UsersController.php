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
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
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
        if (Gate::denies('admin-only')) {
            return redirect()->back();
        }

        // $users = User::all();

        if (Auth::user()->hasRole('admin')) {

            $users = Auth::user()->managers;
            
            foreach ($users as $user) {
                if ($user->roles()->first() == null) {
                    $user->role = [];
                }else{
                    $user->role = $user->roles()->first();
                }
            }

            return Inertia::render('Users/Index', [ 'users' => $users]);

        } elseif(Auth::user()->hasRole('manager')) {

            $users = Auth::user()->employees;

            foreach ($users as $user) {
                if ($user->roles()->first() == null) {
                    $user->role = [];
                }else{
                    $user->role = $user->roles()->first();
                }
            }

            return Inertia::render('Users/Index', [ 'users' => $users]);

        }
        

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('admin-manager-only')) {
            return redirect()->back();
        }
        $roles = Role::all();
        return Inertia::render('Users/Create', [ 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Request::all());
        if (Gate::denies('admin-only')) {
            return redirect()->back();
        }


        Request::validate([
            // 'role_id' => ['required'],
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

        // $role = Role::find(Request::get('role_id'));
        $role = Role::find(2);

        if (Auth::user()->hasRole('admin')) {

            $user = Auth::user()->managers()->create($data);
            $user->save();
            $user->roles()->attach($role);
            return Redirect::route('admin.users.index')->with('success', 'User created.');

        }

        if (Auth::user()->hasRole('manager')) {

            $user = Auth::user()->employees()->create($data);
            $user->save();
            $user->roles()->attach($role);
            return Redirect::route('admin.users.index')->with('success', 'Employee created.');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('admin-only')) {
            return redirect()->back();
        }

        $roles = Role::all();

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Gate::denies('admin-only')) {
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
            $user->update($data);
        }else{
            $user->update($data);
        }
        // if(Request::get('role_id') != null){
        //     $role = Role::find(Request::get('role_id'));
    
        //     $user->roles()->sync($role);
        // }
        

        $user->save();

        return Redirect::route('admin.users.index')->with('success', 'User Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::denies('admin-only')) {
            return redirect()->back();
        }
        $user->roles()->detach();

        $user->delete();

        return Redirect::route('admin.users.index')->with('success', 'User Deleted.');
    }
}
