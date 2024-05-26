<?php

namespace App\Http\Controllers;

use App\Models\FieldBooking;
use Illuminate\Http\Request;
use App\Exports\FieldBookingExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $date = date('Y-m-d');

        $cek_booking = FieldBooking::where('date', $date)->count();
        $booking_lapangan = FieldBooking::where('date', $date)->get();
        return view('admin.dashboard', compact('cek_booking', 'booking_lapangan'));
    }

    public function booking()
    {
        $booking_lapangan = FieldBooking::all();
        return view('admin.booking', compact('booking_lapangan'));
    }

    //report
    public function report()
    {
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');

        $booking_lapangan = FieldBooking::whereBetween('date', [$start_date, $end_date])->get();
        return view('admin.report', compact('booking_lapangan', 'start_date', 'end_date'));
    }

    //report filter
    public function reportFilter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $booking_lapangan = FieldBooking::whereBetween('date', [$start_date, $end_date])->get();
        return view('admin.report', compact('booking_lapangan', 'start_date', 'end_date'));
    }

    //report export
    public function reportExport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $nama_file = 'Laporan_Booking_Lapangan_' . $start_date . '_sd_' . $end_date . '.xlsx';
        // $re = FieldBooking::with('field.fieldLocation.user', 'user','field')
        //     ->whereBetween('date', [$start_date, $end_date])
        //     ->get();
        // dd($re);
        return Excel::download(new FieldBookingExport($start_date, $end_date), $nama_file);
    }

}
