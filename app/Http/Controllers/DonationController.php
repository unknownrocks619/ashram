<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    //

    public function store(Request $request)
    {
        $donation = Donation::where('user_detail_id',$request->user_detail_id)->first();
        if ($donation) {
            $donation->amount += $request->donation;
            // dd($donation);
            // let's call donation controller;
            return $donation->save();
        } else {

            $donation = [
                'user_detail_id' => $request->user_detail_id,
                'amount' => $request->donation,
            ];

            return Donation::create($donation);
        }

    }
}
