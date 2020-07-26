<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Bus;
use App\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Gate;

class TripController extends Controller
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

            $trips = Auth::user()->trips;

            foreach ($trips as $trip) {
                $trip->from = $trip->route->from;
                $trip->to = $trip->route->to;
                $trip->number_of_tikcets = $trip->tickets->count();
                $trip->available_tikcets = $trip->tickets->where('status', false)->count();
                $trip->booked_tikcets = $trip->tickets->where('status', true)->count();
            }
            
            return Inertia::render('Managers/Trips', [ 'trips' => $trips ]);
        }else{


            $trips = Auth::user()->manager->trips;
            
            foreach ($trips as $trip) {
                $trip->from = $trip->route->from;
                $trip->to = $trip->route->to;
                $trip->number_of_tikcets = $trip->tickets->count();
                $trip->available_tikcets = $trip->tickets->where('status', false)->count();
                $trip->booked_tikcets = $trip->tickets->where('status', true)->count();
            }

            return Inertia::render('Trips/Index', [ 'trips' => $trips ]);
        }
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back()->with('success', 'Employee Only Can Create Trips.');
        }

        $buses = Auth::user()->manager->buses;
        
        $routes = Auth::user()->manager->routes;

        return Inertia::render('Trips/Create', [ 'buses' => $buses, 'routes' => $routes ]);
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

        Request::validate(['bus_id' => ['required', 'max:25']]);

        $trip = Auth::user()->manager->trips()->create(
            Request::validate([
                'route_id' => ['required', 'max:25'],
                'bus_id' => ['required', 'max:25'],
                'seats_number' => ['required','integer', 'max:2'],
                'price' => ['required', 'integer', 'max:8'],
                'weight' => ['required', 'max:8'],
                'date' => ['required', 'date', 'max:25'],
            ])
        );

        $trip->save();

        for ($i=0; $i < $trip->seats_number; $i++) { 
            $ticket = $trip->tickets()->create([ 'user_id' => Auth::user()->manager->id, 'bus_id' => Request::get('bus_id'), 'price' => $trip->price, 'seat_number' => $i+1 ]);
        }

        return Redirect::route('trips.index')->with('success', 'Trip created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
       if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }

        $buses = Auth::user()->manager->buses;

        $routes = Auth::user()->manager->routes;

        return Inertia::render('Trips/Edit', [
            'trip' => [
                'id' => $trip->id,
                'route' => $trip->route,
                'route_id' => $trip->route,
                'seats_number' => $trip->seats_number,
                'price' => $trip->price,
                'weight' => $trip->weight,
                'date' => $trip->date,
            ],
            'buses' => $buses,
            'routes' => $routes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }

        $trip->update(
            Request::validate([
            'route_id' => ['required', 'max:25'],
            'seats_number' => ['required','integer', 'max:2'],
            'price' => ['required', 'integer', 'max:8'],
            'weight' => ['required', 'max:8'],
            'date' => ['required', 'date', 'max:25'],
            ])
        );

        return Redirect::route('trips.edit', $trip)->with('success', 'Trip updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }

        $trip->delete();

        return Redirect::route('trips.edit', $trip)->with('success', 'Trip deleted.');
    }

    public function restore(Trip $trip)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }

        $trip->restore();

        return Redirect::route('trips.edit', $trip)->with('success', 'Trip restored.');
    }

}
