<?php
// use Carbon\Carbon;
// Auth
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login')->name('login.attempt')->middleware('guest');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('landing', 'HomeController')->name('landing')->middleware('guest');
Route::get('about', 'HomeController@about')->name('about')->middleware('guest');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth')
    ->group(function () {
        // Users
        Route::resource('/users', 'UsersController');
    });

Route::get('/trips/{trip}/tickets/requests', 'TicketController@tickets_cancel_request')
->name('tickets_cancel_request')->middleware('auth');

Route::resource('/trips/{trip}/tickets', 'TicketController');
Route::put('/tickets/{ticket}', 'TicketController@update')->name('ticket_update');

Route::namespace('Admin')->prefix('managers')->name('managers.')->middleware('auth')
    ->group(function () {
        // Users
        Route::resource('/employees', 'ManagersController');
    });

 // Bookings Search
Route::post('/search', 'PayController@search')->name('search');
Route::get('/search/trips/{trip}/booking', 'PayController@search_booking')->name('search.booking');
Route::post('/search/trips/booking', 'PayController@search_booking_store')->name('search.booking.store');
Route::get('/search/trips/booking/step_tow', 'PayController@step_tow')->name('search.booking.step_tow');
Route::post('/search/trips/booking/step_tow', 'PayController@step_tow_store')->name('serach.booking.step_tow_store');
 
 // cancel_ticket
 Route::get('/bookings/cancel', 'PayController@cancel_ticket')->name('bookings.cancel_ticket');
 // Pay
 Route::post('/bookings/cancel/{ticket}', 'PayController@cancel_ticket_store')->name('bookings.cancel_ticket_store');
 // Pay
 Route::get('/bookings/pay', 'PayController@pay_request')->name('bookings.pay.request');
 Route::get('/bookings/pay/{ticket_number}', 'PayController@pay')->name('bookings.pay');

 // Pay Methods
 Route::get('/bookings/pay/{ticket_number}/methods/{method}', 'PayController@get_pay_method')
 ->name('bookings.pay.methods');

 // Pay Methods Complete
 Route::post('/bookings/pay/{ticket_number}/methods/{method}', 'PayController@pay_method_store')
 ->name('bookings.pay.methods.store');


Route::middleware('auth')->group(function () {
    // Buses
    Route::resource('/buses', 'BusController');

    // Buses
    Route::resource('/routes', 'RouteController');

    // Trips
    Route::resource('/trips', 'TripController');

    // Customers
    Route::resource('/customers', 'CustomerController');

    // Invoices
    Route::resource('/invoices', 'InvoiceController');
    
    // Dashboard
    Route::get('/', 'DashboardController')->name('dashboard');
    
    // Calender
    Route::get('/calender', 'DashboardController@index')->name('calender');
    
    // Home
    Route::get('/home', 'DashboardController@home')->name('home');
    
    // Booking
    Route::get('/booking', 'DashboardController@booking')->name('booking');
    
});

// Bookings
Route::resource('/bookings', 'BookingController');

// 500 error
Route::get('500', function () {
    echo $fail;
});

Route::get('/trips/{trip}/booking', 'DashboardController@step_one')->name('trips.booking');
Route::post('/booking/step_one_store', 'DashboardController@step_one_store')->name('booking.step_one_store');
Route::get('/booking/step_tow', 'DashboardController@step_tow')->name('booking.step_tow');
Route::post('/booking/step_tow_store', 'DashboardController@step_tow_store')->name('booking.step_tow_store');
