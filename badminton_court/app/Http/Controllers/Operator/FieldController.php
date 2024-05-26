<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->fieldLocations->first()){
            $datas = Field::where('field_location_id', auth()->user()->fieldLocations->first()->id)->get();
        }else{
            $datas = null;
        }
        return view('operator.field.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.field.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'field_location_id' => 'required',
            'image' => 'required',
            'description' => 'required',
            'open' => 'required',
            'close' => 'required'
        ]);

        //proses upload file
        $image = $request->file('image');
        $image->storeAs('public/field', $image->hashName());
        $price = $request->price ?? 55000;
        //simpan data
        $field = new Field();
        $field->name = $request->name;
        $field->field_location_id = $request->field_location_id;
        $field->price = $price;
        $field->image = $image->hashName();
        $field->description = $request->description;
        $field->open = $request->open;
        $field->close = $request->close;
        $simpan = $field->save();

        //jika berhasil
        if($simpan){
            return redirect()->route('operator.field.index', ['status' => 'sukses-baru']);
        }else{
            return redirect()->route('operator.field.index', ['status' => 'gagal']);
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
        $field = Field::find($id);
        return view('operator.field.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'open' => 'required',
            'close' => 'required'
        ]);

        //get data field by ID
        $field = Field::find($id);

        //jika user ingin mengganti gambar
        if($request->hasFile('image')){
            //hapus old image
            $image = $request->file('image');
            $image->storeAs('public/field', $image->hashName());
            $field->image = $image->hashName();
        }

        //update data field
        $field->name = $request->name;
        $field->price = $request->price;
        $field->description = $request->description;
        $field->open = $request->open;
        $field->close = $request->close;
        $simpan = $field->save();

        //jika berhasil
        if($simpan){
            return redirect()->route('operator.field.index', ['status' => 'sukses-edit']);
        }else{
            return redirect()->route('operator.field.index', ['status' => 'gagal-edit']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        //get data field by ID
        $field = Field::find($id);

        //hapus image
        $image = $field->image;
        Storage::disk('local')->delete('public/field/'.$image);

        //delete yang berkaitan
        FieldBooking::where('field_id', $id)->delete();

        //hapus data field
        $hapus = $field->delete();

        //jika berhasil
        if($hapus){
            return redirect()->route('operator.field.index', ['status' => 'sukses-hapus']);
        }else{
            return redirect()->route('operator.field.index', ['status' => 'gagal-hapus']);
        }
    }
}
