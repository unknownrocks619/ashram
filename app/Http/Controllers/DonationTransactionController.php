<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonationTransaction;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;

class DonationTransactionController extends Controller
{
    //

    public function store(Request $request, Booking $booking = null) 
    {
        $donation_transaction = [
            'user_detail_id' => $booking->user_detail_id,
            'bookings_id' => ($booking) ? $booking->id : null,
            'created_by_user' => (Auth::guard('admin')->check()) ? Auth::guard('admin')->user()->id : 0,
            'donation_amount' => $request->donation ? $request->donation : 0,
            'remark' => $request->remarks,
            'source' => ($booking) ? "Visit" : "Charity"
        ];

        return DonationTransaction::create($donation_transaction);
    }
}
