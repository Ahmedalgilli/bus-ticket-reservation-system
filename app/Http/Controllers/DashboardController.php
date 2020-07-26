<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Gate;
use App\User;
use App\Trip;
use App\Route;
use App\Customer;
use App\Ticket;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (Auth::user()) {
            if(Auth::user()->hasRole('admin')){
                return Inertia::render('Dashboard/Index', [
                    'users' => Auth::user()->managers
                ]);
            }elseif(Auth::user()->hasRole('manager')){
                return Inertia::render('Dashboard/ManagerDashboard', [
                    'routes' => Auth::user()->routes,
                    'trips' => Auth::user()->trips,
                    'buses' => Auth::user()->buses,
                    'employees' => Auth::user()->employees
                ]);
            }elseif(Auth::user()->hasRole('employee')){
                return Inertia::render('Dashboard/EmployeeDashboard', [
                    'routes' => Auth::user()->manager->routes,
                    'trips' => Auth::user()->manager->trips,
                    'buses' => Auth::user()->manager->buses
                ]);
            }
        }else{
            return Redirect::route('landing');
        }
    }
    
    public function front()
    {
        return Inertia::render('Dashboard/Landing');
    }

    public function index()
    {
        $trips = Trip::all();

        $colors = ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1', 'red'];

        $d=mktime(3, 19, 2020);
        $d1=mktime( 3, 19, 2020);
        $dd = date("Y-m-d", $d);
        $dd2 = date("Y-m-d", $d1);

        $events = [];

        foreach ($trips as $trip) {
            $trip->from = $trip->route->from;
            $trip->to = $trip->route->to;
            $trip->number_of_tikcets = $trip->tickets->count();
            $trip->available_tikcets = $trip->tickets->where('status', false)->count();
            $trip->booked_tikcets = $trip->tickets->where('status', true)->count();
        }

        for ($i=0; $i < $trips->count(); $i++) { 
            $events[$i]['id'] = $i;
            $events[$i]['name'] = $trips[$i]->from.' - '.$trips[$i]->to;
            $events[$i]['color'] = $colors[7];
            $events[$i]['start'] = $dd;
            $events[$i]['end'] = $dd2;
            $events[$i]['details'] = $trips[$i];
        }
        
        return Inertia::render('Dashboard/TripsCalender', [ 'events' => $events ]);
    }

    public function home()
    {
        // $routes = Route::all();
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }

        $routes = Auth::user()->routes;

        foreach ($routes as $route) {
            $route->name = $route->from. ' - ' .$route->to;
            $route->allTrips = $route->trips;
            // $route->company_name= $route->user()->manager->companay_name;
            $route->manager = $route->user->manager;
            $route->employee = $route->user;
        }

        // return $routes;

        return Inertia::render('Dashboard/Home', [ 'routes' => $routes ]);
    }

    public function booking(Trip $trip)
    {
        $tickets = $trip->tickets;
        
        return Inertia::render('Dashboard/StepOne', [ 'tickets' => $tickets ]);
    }
    
    public function step_one(Trip $trip)
    {
        $tickets = $trip->tickets;

        return Inertia::render('Dashboard/StepOne', [ 'tickets' => $tickets ]);
    }

    public function step_one_store(Request $request)
    {
        // Store a piece of data in the session...
        session(['step_one_data' => Request::all()]);
        // $data = session()->get('step_one_data');
        $customer_seats_numbers = session()->get('step_one_data');

        return Redirect::route('booking.step_tow');
    }

    public function step_tow()
    {
        $customer_seats_numbers = session()->get('step_one_data');

        return Inertia::render('Dashboard/StepTow', [ 'customer_seats_numbers' => $customer_seats_numbers ]);
    }

    public function step_tow_store(Request $request)
    {
        // dd(Request::all());

        $customers = [];

        $customerData = Request::all();

        // dd($customerData);

        $index = 0;
        $id = [];

        foreach ($customerData as $element) {

            $customer = Auth::user()->customers()->create([
                'name' => $element['name'],
                'phone' => $element['phone']
            ]);

            $ticket = Ticket::find($element['ticket']['id']);

            $id[$index] = $ticket->id;

            $ticket->update([
                'customer_id' => $customer->id,
                'status' => 1
            ]);

            $customers[$index] = $customer;

            $index++;

        }

        $index = 0;

        foreach ($customers as $customer) {
            $customer->ticket = Ticket::find($id[$index]);
            $index++;
        }

        $data = $customers;

        return Inertia::render('Dashboard/Invoice', [ 'customers' => $customers, 'data' => $data ]);
    }
}
