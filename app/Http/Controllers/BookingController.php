<?php

namespace App\Http\Controllers;

use App\User;
use App\Bus;
use App\Trip;
use App\Booking;
use App\Ticket;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Gate::denies('employee-only')) {
        //     return redirect()->back();
        // }
        $bookings = Booking::all();

        // foreach ($bookings as $booking) {
        //     $booking->data = json_decode($booking['customers']);
        // }

        // return json_decode($bookings[0]['customers']);
        return $bookings;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (Gate::denies('employee-only')) {
        //     return redirect()->back();
        // }
        $data = $request->all();
        $count = 0;
        for ($i=0; $i < count($data)-1; $i++) {
            $item[$i]['name'] = $data[$i]['name'];
            $item[$i]['phone'] = $data[$i]['phone'];
            $item[$i]['customer_id'] = $data[$i]['ticket']['customer_id'];
            $count++;
        }

        $user_id = $data[0]['user_id'];
        $bus_id = $data[0]['bus_id'];
        $trip_id = $data[0]['trip_id'];

        $invoice = Invoice::create([
            'user_id' => $user_id,
            'bus_id' => $bus_id,
            'trip_id' => $trip_id,
            'customers' => json_encode($item),
            'total' => $data[$count],
        ]);

        $invoice->save();

        $booking = Booking::create([
            'user_id' => $user_id,
            'bus_id' => $bus_id,
            'trip_id' => $trip_id,
            'invoice_id' => $invoice->id,
            'customers' => json_encode($item),
            'total' => $data[$count],
        ]);

        $booking->save();

        $ticket_number = $booking->user_id.'-'
                        .$booking->id.'-'
                        // .$booking->invoice_id.'-'
                        .$booking->trip_id.'-'
                        .$booking->bus_id.'-'
                        // .count($booking->customers).'-'
                        .$booking->total;
        $company = User::find($user_id);
        $trip = Trip::find($trip_id);
        $bus = Bus::find($bus_id);
        $total = $invoice->total;
        $ticket_number = $ticket_number;

        session( [ 'customer_pay_data' => [
            'company' => $company,
            'trip' => $trip,
            'bus' => $bus,
            'invoice' => $invoice,
            'total' => $total,
            'ticket_number' => $ticket_number,
        ]]);

        return Redirect::route('bookings.pay', $ticket_number);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        if (Gate::denies('employee-only')) {
            return redirect()->back();
        }
        //
    }
}
