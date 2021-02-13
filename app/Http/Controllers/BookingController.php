<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\userDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display list of all bookings 
     * intended only for admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::guard('admin')->check() ){

            $bookings = Booking::paginate();
            dd($bookings);
            return view('admin.bookings.list',compact('bookings'));
        }
        abort(404);
    }

    /**
     * Show the form for creating a new booking resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request , $user_id = null)
    {
        //
        $data = [];
        if ($request->user_id || $user_id ) {
            // get user detail.
            $dec_user_id = ($user_id) ? decrypt($user_id) : ( ($request->user_id) ? decrypt($request->user_id)  : "");

            if ($dec_user_id)
            {
                $user_detail = userDetail::findOrFail($dec_user_id);
            } 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
