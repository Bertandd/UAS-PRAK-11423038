<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\FieldLocation;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    //
    public function field()
    {
        date_default_timezone_set('Asia/Jakarta');
        $field = Field::orderBy('name','asc')->paginate(9);
        $locations = FieldLocation::orderBy('name','asc')->where('id','!=',999)->get();
        $filter = 00;
        $start = '08:00';
        $end = '23:00';
        $empty = '';
        $date = date('Y-m-d');
        return view('guest.field',compact('field','locations','filter','start','end','empty','date'));
    }

    //register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "user"; //default role "user"
        $user->save();

        //return dengan session status
        return redirect()->route('login')->with('status','Register berhasil, silahkan login');
    }

    public function fieldByLocation(Request $request)
    {
        //locale indonesia utc+7
        date_default_timezone_set('Asia/Jakarta');
        $filter = $request->filter;
        $date = $request->date;
        $start = $request->start;
        $end = $request->end;
        $empty = $request->empty;
        // dd($filter)
        if($filter!=00){
            if($empty == 'on'){
                $jam = array('08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00');

                $sudah_booking = Field::where('field_location_id', $request->filter)
                    ->whereHas('bookings', function($q) use ($jam, $date) {
                        $q->where('date', $date);
                        foreach ($jam as $time) {
                            $start_time = $time;
                            $end_time = date('H:i:s', strtotime($time) + 3600); // Asumsikan durasi booking 1 jam
                            $q->orWhere(function($subQuery) use ($start_time, $end_time) {
                                $subQuery->where('start_time', '<=', $start_time)
                                        ->where('end_time', '>=', $end_time);
                            });
                        }
                    }, '=', count($jam)) // Harus ada booking untuk semua jam dalam array
                    ->pluck('id');

                // $field = Field::where('field_location_id',$request->filter)->whereNotIn('id',$sudah_booking)->orderBy('name','asc')->paginate(9);
                $field = Field::where('field_location_id',$request->filter)->whereNotIn('id',$sudah_booking)->orderBy('name','asc')->paginate(9);
            }else{
                $field = Field::where('field_location_id',$request->filter)->where('open','>=',$start)->where('close','<=',$end)->orderBy('name','asc')->paginate(9);
                // dd($field);
            }
        }else{
            $field = Field::where('open','>=',$start)->where('close','<=',$end)->orderBy('name','asc')->paginate(9);
        }
        $locations = FieldLocation::orderBy('name','asc')->where('id','!=',999)->get();
        return view('guest.field',compact('field','locations','filter','start','end','empty','date'));

    }

}
