<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }
        
        $customeres = Customer::all();

        return Inertia::render('Customeres/Index', [ 'customeres' => $customeres ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        return Inertia::render('Customeres/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        Auth::user()->customeres()->create(
            Request::validate([
            'name' => ['required', 'max:25'],
            'phone' => ['required', 'max:15'],
            ])
        );

        return Redirect::route('customeres.index')->with('success', 'Customer created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        return Inertia::render('Customeres/Edit', [
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'tickets' => $customer->tickets,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $customer->update(
            Request::validate([
                'name' => ['required', 'max:25'],
                'phone' => ['required', 'string', 'max:10'],
            ])
        );

        return Redirect::route('customeres.edit', $customer)->with('success', 'Customer updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $customer->delete();

        return Redirect::route('customeres.edit', $customer)->with('success', 'Customer deleted.');
    }

    public function restore(Customer $customer)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $customer->restore();

        return Redirect::route('customeres.edit', $customer)->with('success', 'Customer restored.');
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required', 'max:8'],
            'name' => ['required', 'max:10'],
            'phone' => ['required', 'max:15', 'unique:customeres'],
        ]);
    }
}
