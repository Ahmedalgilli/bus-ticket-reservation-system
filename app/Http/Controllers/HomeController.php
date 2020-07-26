<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Trip;
use App\Route;
use App\Customer;
use App\Ticket;

class HomeController extends Controller
{
    public function __invoke()
    {
        $routes = Route::all();
        // $routes = Auth::user()->routes;

        foreach ($routes as $route) {
            $route->name = $route->from. ' - ' .$route->to;
            $route->allTrips = $route->trips;
        }

        // return $routes;

        return Inertia::render('Home/Index', [ 'routes' => $routes ]);
    }
    public function about()
    {
        return Inertia::render('Home/About');
    }
    
    public function front()
    {
        return Inertia::render('Home/Landing');
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
        $routes = Auth::user()->routes;

        foreach ($routes as $route) {
            $route->name = $route->from. ' - ' .$route->to;
            $route->allTrips = $route->trips;
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

        return Inertia::render('Dashboard/Invoice', [ 'customers' => $customers ]);
    }
}
