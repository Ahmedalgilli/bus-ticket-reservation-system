<?php

namespace App\Http\Controllers;

use App\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Gate;

class RouteController extends Controller
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

            $routes = Auth::user()->routes;
            
            return Inertia::render('Routes/Index', [ 'routes' => $routes ]);
        }

        $routes = Auth::user()->manager->routes;

        return Inertia::render('Routes/Index', [ 'routes' => $routes ]);

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
        return Inertia::render('Routes/Create');
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

        Auth::user()->manager->routes()->create(
            Request::validate([
            'from' => ['required', 'max:25'],
            'to' => ['required', 'string', 'max:15'],
            'duration' => ['required', 'integer', 'max:8'],
            ])
        );

        return Redirect::route('routes.index')->with('success', 'Route created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }

        $route->allTrips = $route->trips;
        $route->manager = $route->user->manager;
        $route->employee = $route->user;

        if (Auth::user()->hasRole('manager')) {
            return Inertia::render('Routes/Show', [
                '_route' => $route
            ]);
        } else {
            return Inertia::render('Routes/EmployeeShow', [
                '_route' => $route
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        return Inertia::render('Routes/Edit', [
            '_route' => [
                'id' => $route->id,
                'from' => $route->from,
                'to' => $route->to,
                'duration' => $route->duration,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $route->update(
            Request::validate([
                'from' => ['required', 'max:25'],
                'to' => ['required', 'string', 'max:10'],
                'duration' => ['required', 'max:10'],
            ])
        );

        return Redirect::route('routes.edit', $route)->with('success', 'Route updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $route->delete();

        return Redirect::route('routes.edit', $route)->with('success', 'Route deleted.');
    }

    public function restore(Route $route)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        $route->restore();

        return Redirect::route('routes.edit', $route)->with('success', 'Route restored.');
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
            'from' => ['required', 'max:10'],
            'to' => ['required', 'max:15'],
            'duration' => ['required', 'max:10'],
        ]);
    }
}
