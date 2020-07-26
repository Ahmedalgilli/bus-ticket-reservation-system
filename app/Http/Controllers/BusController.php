<?php

namespace App\Http\Controllers;

use App\Bus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Gate;

class BusController extends Controller
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
        if(Auth::user()->hasRole('manager')){

            $buses =Auth::user()->buses;
            
            return Inertia::render('Buses/Index', [ 'buses' => $buses ]);
        }

        $buses =Auth::user()->manager->buses;

        return Inertia::render('Buses/Index', [ 'buses' => $buses ]);
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
        return Inertia::render('Buses/Create');
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
        Auth::user()->manager->buses()->create(
            Request::validate([
            'name' => ['required', 'max:25'],
            'license_plate_number' => ['required', 'string', 'max:15', 'unique:buses'],
            'seats_number' => ['required', 'max:8'],
            ])
        );

        return Redirect::route('buses.index')->with('success', 'Bus created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        return Inertia::render('Buses/Edit', [
            'bus' => [
                'id' => $bus->id,
                'name' => $bus->name,
                'license_plate_number' => $bus->license_plate_number,
                'seats_number' => $bus->seats_number,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $bus)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $bus->update(
            Request::validate([
                'name' => ['required', 'max:25'],
                'license_plate_number' => ['required', 'string', 'max:10'],
                'seats_number' => ['required', 'max:10'],
            ])
        );

        return Redirect::route('buses.edit', $bus)->with('success', 'Bus updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $bus->delete();

        return Redirect::route('buses.edit', $bus)->with('success', 'Bus deleted.');
    }

    public function restore(Bus $bus)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $bus->restore();

        return Redirect::route('buses.edit', $bus)->with('success', 'Bus restored.');
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
            'license_plate_number' => ['required', 'max:15', 'unique:buses'],
            'seats_number' => ['required', 'max:10'],
        ]);
    }
}
