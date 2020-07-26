<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Gate;
use App\User;
use App\Bus;
use App\Trip;
use App\Route;
use App\Customer;
use App\Ticket;
use App\Invoice;
use App\Booking;

class PayController extends Controller
{
    public function pay_request()
    {
        return Inertia::render('Dashboard/PayRequest');
    }

    public function pay($ticket_number)
    {
        $data = explode('-', $ticket_number);

        $booking = Booking::where([ 
            'id' => $data[1],
            'user_id' => $data[0],
            'trip_id' => $data[2],
            'bus_id' => $data[3],
            'total' => $data[4]
        ])->first();

        $con = session()->get('customer_pay_data');

        $value = $con === null ? true : false;

        if($booking === null){

            return Redirect::back()->with([ 'success' => 'Invoice Number is Not Exists' ]);
        
        }elseif(!$value){

            $customer_pay_data = session()->get('customer_pay_data');

            return Inertia::render('Dashboard/Pay', [ 'customer_pay_data' => $customer_pay_data ]);
        
        }else{

            $company = User::find($data[0]);
            $trip = Trip::find($data[2]);
            $bus = Bus::find($data[3]);
            $invoice = Invoice::find($booking->invoice_id);

            session( [ 'customer_pay_data' => [
                'company' => $company,
                'trip' => $trip,
                'bus' => $bus,
                'invoice' => $invoice,
                'total' => $booking->total,
                'ticket_number' => $ticket_number,
            ]]);

            return Redirect::route('bookings.pay', $ticket_number);

        }

    }
    
    public function get_pay_method($ticket_number, $method)
    {
        $customer_pay_data = session()->get('customer_pay_data');

        return Inertia::render('Dashboard/PayMethod', [ 
                'customer_pay_data' => $customer_pay_data ,
                'method' => $method
            ]);
    }

    public function pay_method_store($ticket_number, $method_id, Request $request)
    {
        Request::validate([
            'customer_acount_number' => ['required', 'min:6', 'max:15'],
        ]);
        
        $try_again = 'Please Try Again With Correct Info Whoops';

        $messages = [ 'Payment Successfully', 'You Enter Invalid Acount Number', "You Don't Have Enough Balance In This Acount", 'Connection Error' ];
        
        $message_number = random_int(1, count($messages));

        $cs = json_decode(session()->get('customer_pay_data')['invoice']['customers']);
        $index = 0;
        $tickets = [];

        foreach($cs as $c){
            $ticket = Ticket::where('customer_id', $c->customer_id)->first();
            $ticket->route = $ticket->trip->route;
            $ticket->customer = $ticket->customer;
            $tickets[$index] = $ticket;

            $index++;
        }

        $customer_pay_data = session()->get('customer_pay_data');

        if(Request::get('customer_acount_number') == 11111111){
        // if($message_number != 1){
            return Redirect::back()->with([ 'success' => $messages[1].' '.$try_again ]);
        }elseif(Request::get('customer_acount_number') == 22222222){
            return Redirect::back()->with([ 'success' => $messages[2].' '.$try_again ]);
        }elseif(Request::get('customer_acount_number') == 33333333){
            return Redirect::back()->with([ 'success' => $messages[3].' '.$try_again ]);
        }else{
            return Inertia::render('Tickets/TicketView', [ 
                'customer_pay_data' => $customer_pay_data,
                'tickets' => $tickets,
                'method_id' => $method_id,
                'ticket_number' => $ticket_number
                ]);
        }

    }

    public function cancel_ticket()
    {
        return Inertia::render('Tickets/RequestSend');
    }

    public function cancel_ticket_store($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        
        if($ticket === null){
            return Redirect::back()->with([ 'success' => 'Ticket Number is Not Exists' ]);
        }elseif($ticket->requested_to_cancel_cancel == true){
            return Redirect::back()->with([ 'success' => 'Request Is Allready Sended Successfuly' ]);
        }else{
            $ticket->update([ 'requested_to_cancel_cancel' => true ]);
            return Redirect::back()->with([ 'success' => 'Request Is Sended Successfuly' ]);
        }

    }
    
    public function cancel_ticket_aprove_store(Ticket $ticket)
    {
        $ticket->update([ 'requested_to_cancel_cancel' => true ]);
        
        return Redirect::back()->with([ 'success' => 'Request Sended Successfuly' ]);
    }
    public function search(Request $request)
    {
        // dd(Request::all());

        $route = Route::where([ 'from' => Request::get('from'), 'to' => Request::get('to') ])->first();

        
        $data = [];
        $date = Carbon::createFromFormat('m/d/Y', Request::get('date'))->format('Y-m-d');

        $today_date = Carbon::now()->format('Y-m-d');

        foreach ($route->trips as $trip) {
            $trip->from = $trip->route->from;
            $trip->to = $trip->route->to;
            $trip->company = $trip->user->first_name;
            $trip->number_of_tikcets = $trip->tickets->count();
            $trip->available_tikcets = $trip->tickets->where('status', false)->count();
            $trip->booked_tikcets = $trip->tickets->where('status', true)->count();
            $trip_date = Carbon::parse($trip->date)->format('Y-m-d');

            if($date <= $trip_date){
                array_push($data, $trip);                
            }
        }

        if(count($data) > 0 ){
            return Inertia::render('Home/ShowTrips', [ 'trips' => $data, 'data' => Request::all() ]);
        }else{
            return Redirect::back()->with([ 'success' => 'No Trips Available with this Date '.Request::get('date') ]);
        }
    }

    public function show_trip_seats(Route $route)
    {
        $route->allTrips = $route->trips;
        $route->manager = $route->user->manager;
        $route->employee = $route->user;
        return Inertia::render('Home/ShowSeats', [
            '_route' => $route
        ]);
    }
    
    public function search_booking(Trip $trip)
    {
        $tickets = $trip->tickets;

        return Inertia::render('Home/ShowSeats', [ 'tickets' => $tickets ]);
    }

    public function search_booking_store(Request $request)
    {
        session(['step_one_data' => Request::all()]);

        $customer_seats_numbers = session()->get('step_one_data');

        return Redirect::route('search.booking.step_tow');
    }

    public function step_tow()
    {
        $customer_seats_numbers = session()->get('step_one_data');

        return Inertia::render('Home/StepTow', [ 'customer_seats_numbers' => $customer_seats_numbers ]);
    }

    public function step_tow_store(Request $request)
    {
        // dd(Request::all());

        $customers = [];

        $customerData = Request::all();

        // dd($customerData[0]['ticket']['user_id']);

        $user = User::find($customerData[0]['ticket']['user_id']);
        // dd($user->customers);
        $index = 0;
        $id = [];

        foreach ($customerData as $element) {

            $customer = $user->customers()->create([
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

        return Inertia::render('Home/Invoice', [ 'customers' => $customers, 'data' => $data ]);
    }
    
}
