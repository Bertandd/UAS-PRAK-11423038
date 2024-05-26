<?php

namespace App\Http\Controllers;

use App\Models\FieldBooking;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $cek_booking = FieldBooking::where('status', 'pending')->count();
        $booking_lapangan = FieldBooking::where('status', 'pending')->get();
        return view('operator.dashboard', compact('cek_booking', 'booking_lapangan'));
    }

    public function booking()
    {
        //data booking sesuai operator id
        $booking_lapangan = FieldBooking::whereHas('field.fieldLocation', function($q){
            $q->where('user_id', auth()->user()->id);
        })->get();
        return view('operator.booking', compact('booking_lapangan'));
    }

    public function confirm($id)
    {
        $booking = FieldBooking::find($id);
        $booking->status = 'approved';
        $booking->save();
        return redirect()->back()->with('status', 'approved');
    }

    public function reject($id)
    {
        $booking = FieldBooking::find($id);
        $booking->status = 'rejected';
        $booking->save();
        return redirect()->back()->with('status', 'rejected');
    }
}
