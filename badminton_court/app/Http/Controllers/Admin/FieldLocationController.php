<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldBooking;
use App\Models\FieldLocation;
use App\Models\User;
use Illuminate\Http\Request;

class FieldLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = FieldLocation::where('id', '!=', 999)->get();
        return view('admin.field-location.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'operator')->where('id', '!=', 999)->get();
        return view('admin.field-location.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'user_id' => 'required'
        ]);


        //simpan data
        $FieldLocation = new FieldLocation;
        $FieldLocation->name = $request->name;
        $FieldLocation->address = $request->address;
        $FieldLocation->user_id = $request->user_id;
        $simpan = $FieldLocation->save();

        //jika berhasil
        if($simpan){
            //insert 1 lapangan
            $Field = new Field;
            $Field->name = 'Lapangan 1';
            $Field->field_location_id = $FieldLocation->id;
            $Field->price = 55000;
            $Field->image = 'default.jpg';
            $Field->description = 'Deskripsi lapangan 1';
            $Field->open = '08:00';
            $Field->close = '22:00';
            $Field->save();
            return redirect()->route('admin.field-locations.index', ['status' => 'sukses-baru']);
        }else{
            return redirect()->route('admin.field-locations.index', ['status' => 'gagal-baru']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = FieldLocation::find($id);
        $users = User::where('role', 'operator')->where('id', '!=', 999)->get();
        return view('admin.field-location.edit', compact('data', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'user_id' => 'required'
        ]);


        //simpan data
        $FieldLocation = FieldLocation::find($id);
        $FieldLocation->name = $request->name;
        $FieldLocation->address = $request->address;
        $FieldLocation->user_id = $request->user_id;
        $simpan = $FieldLocation->save();

        //jika berhasil
        if($simpan){
            return redirect()->route('admin.field-locations.index', ['status' => 'sukses-edit']);
        }else{
            return redirect()->route('admin.field-locations.index', ['status' => 'gagal-edit']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $FieldLocation = FieldLocation::find($id);

        $field = Field::where('field_location_id', $FieldLocation->id)->get();
        foreach($field as $f){
            $fieldBooking = FieldBooking::where('field_id', $f->id)->get();
            foreach($fieldBooking as $fb){
                $fb->delete();
            }
            $f->delete();
        }
        $hapus = $FieldLocation->delete();
        //jika berhasil
        if($hapus){
            return redirect()->route('admin.field-locations.index', ['status' => 'sukses-hapus']);
        }else{
            return redirect()->route('admin.field-locations.index', ['status' => 'gagal-hapus']);
        }
    }
}
