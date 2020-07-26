<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Trip;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Trip $trip)
    {
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }

        $tickets = $trip->tickets;

        foreach ($tickets as $ticket) {
            $ticket->bus = $ticket->bus;
            $ticket->trip = $ticket->trip;
            $ticket->user = $ticket->user;
            $ticket->route = $ticket->trip->route;
        }
        
        return Inertia::render('Tickets/Index', [ 'tickets' => $tickets ]);
    }
    public function tickets_cancel_request(Trip $trip)
    {
        if (Gate::denies('manager-employee-only')) {
            return redirect()->back();
        }
        $tickets = $trip->tickets;
        foreach ($tickets as $ticket) {
            $ticket->bus = $ticket->bus;
            $ticket->trip = $ticket->trip;
            $ticket->user = $ticket->user;
            $ticket->route = $ticket->trip->route;
        }
        return Inertia::render('Tickets/CancelRequest', [ 'tickets' => $tickets ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
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
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
        $ticket->update(['status' => false]);
        return redirect()->back()->with([ 'success' => 'ticket number '.$ticket->id.' status updated successfully' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if (Gate::denies('all-users')) {
            return redirect()->back();
        }
        //
    }
}
