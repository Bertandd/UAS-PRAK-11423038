<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldBooking;
use App\Models\Product;
use App\Models\ProductBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //profile
    public function profile()
    {
        $profile = User::find(Auth::id());
        return view('user.profile', compact('profile'));
    }

    //update profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $id = Auth::id();
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        //cek password
        if ($request->password) {
            $request->validate([
                'password' => 'required|min:6',
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('status', 'sukses-edit');
    }

    public function index(){

        //where date and user_id
        $cek_booking = FieldBooking::where('date', date('Y-m-d'))->where('user_id', Auth::id())->orWhere('status', 'pending')->where('user_id', Auth::id())->count();
        $booking_lapangan = FieldBooking::where('date', date('Y-m-d'))->where('user_id', Auth::id())->orWhere('status', 'pending')->where('user_id', Auth::id())->get();

        return view('user.dashboard', compact('cek_booking', 'booking_lapangan'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'field_id' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Konversi waktu ke format timestamp Unix
        $start_time = strtotime($request->start_time);
        $end_time = strtotime($request->end_time);

        // Hitung selisih waktu dalam detik
        $total_seconds = $end_time - $start_time;

        // Konversi total detik ke jam
        $total_hours = $total_seconds / 3600; // 1 jam = 3600 detik

        // Pembulatan nilai total jam
        $total_hours = round($total_hours, 2); //

        //validasi waktu mulai dan selesai
        if ($total_hours < 2 ) {
            return redirect()->back()->with('status', 'waktu-tidak-valid');
        }
        //validasi jam buka dan tutup lapangan
        $field = Field::find($request->field_id);
        if ($request->start_time < $field->open || $request->end_time > $field->close) {
            return redirect()->back()->with('status', 'waktu-tidak-valid');
        }

        //validasi jadwal bentrok
        $cek = FieldBooking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>=', $request->start_time)
                    ->where('status', 'approved')
                    ->orWhere('start_time', '<=', $request->end_time)
                    ->where('end_time', '>=', $request->end_time)
                    ->where('status', 'approved');

            })->count();

        if ($cek > 0) {
            return redirect()->back()->with('status', 'jadwal-bentrok');
        }

        //hitung total harga
        $field = Field::find($request->field_id);
        $total_harga = $field->price * $total_hours;

        //simpan booking
        $booking = new FieldBooking();
        $booking->field_id = $request->field_id;
        $booking->user_id = Auth::id();
        $booking->date = $request->date;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->total_price = $total_harga;
        $booking->status = 'pending';
        $simpan = $booking->save();

        if ($simpan) {
            return redirect()->route('user.booking-history')->with('status', 'sukses-baru');
        } else {
            return redirect()->back()->with('status', 'gagal-baru');
        }
    }

    public function booking($id, $date, $start, $end)
    {
        $field = Field::find($id);
        $fields = Field::all();
        return view('user.booking', compact('field', 'fields', 'date', 'start', 'end'));
    }

    public function edit($id)
    {
        $data = FieldBooking::find($id);
        $fields = Field::all();
        return view('user.booking_edit', compact('data', 'fields'));
    }

    public function edit_store(Request $request, $id)
    {
        $request->validate([
            'field_id' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        //simpan booking
        $booking =FieldBooking::find($id);

        // cek booking status
        if($booking->status!=='pending'){
            return redirect()->route('user.booking-history')->with('status', 'data-disabled');
        }

        // Konversi waktu ke format timestamp Unix
        $start_time = strtotime($request->start_time);
        $end_time = strtotime($request->end_time);

        // Hitung selisih waktu dalam detik
        $total_seconds = $end_time - $start_time;

        // Konversi total detik ke jam
        $total_hours = $total_seconds / 3600; // 1 jam = 3600 detik

        // Pembulatan nilai total jam
        $total_hours = round($total_hours, 2); //

        //validasi waktu mulai dan selesai
        if ($total_hours < 2 ) {
            return redirect()->back()->with('status', 'waktu-tidak-valid');
        }
        //validasi jam buka dan tutup lapangan
        $field = Field::find($request->field_id);
        if ($request->start_time < $field->open || $request->end_time > $field->close) {
            return redirect()->back()->with('status', 'waktu-tidak-valid');
        }

        //validasi jadwal bentrok
        $cek = FieldBooking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request, $id) {
                $query->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>=', $request->start_time)
                    ->where('status', 'approved')
                    ->where('id','!=',$id)
                    ->orWhere('start_time', '<=', $request->end_time)
                    ->where('end_time', '>=', $request->end_time)
                    ->where('status', 'approved')
                    ->where('id','!=',$id)
                    ;

            })->count();

        if ($cek > 0) {
            return redirect()->back()->with('status', 'jadwal-bentrok');
        }

        //hitung total harga
        $field = Field::find($request->field_id);
        $total_harga = $field->price * $total_hours;


        $booking->field_id = $request->field_id;
        $booking->user_id = Auth::id();
        $booking->date = $request->date;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->total_price = $total_harga;
        $booking->status = 'pending';
        $simpan = $booking->save();

        if ($simpan) {
            return redirect()->route('user.booking-history')->with('status', 'sukses-baru');
        } else {
            return redirect()->back()->with('status', 'gagal-baru');
        }
    }


    public function bookingHistory()
    {
        $booking = FieldBooking::where('user_id', Auth::id())->get();
        return view('user.booking-history', compact('booking'));
    }

}
