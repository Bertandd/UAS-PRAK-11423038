<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = User::where('role', 'operator')->where('id', '!=', 999)->get();
        return view('admin.operator.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);


        //simpan data
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'operator';
        $simpan = $user->save();

        //jika berhasil
        if($simpan){
            return redirect()->route('admin.operator.index', ['status' => 'sukses-baru']);
        }else{
            return redirect()->route('admin.operator.index', ['status' => 'gagal']);
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
        $data = User::find($id);
        return view('admin.operator.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //cek validasi
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        //get data field by ID
        $user = User::find($id);
        //jika user ingin mengganti password
        if($request->password){
            $this->validate($request, [
                'password' => 'required|min:6',
            ]);
            $user->password = Hash::make($request->password);
        }

        //update data field
        $user->name = $request->name;
        $user->email = $request->email;
        $simpan = $user->save();

        //jika berhasil
        if($simpan){
            return redirect()->route('admin.operator.index', ['status' => 'sukses-edit']);
        }else{
            return redirect()->route('admin.operator.index', ['status' => 'gagal-edit']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        //get data field by ID
        $user = User::find($id);

        //jika ada lokasi maka pindahkan ke user 999
        $fields = FieldLocation::where('user_id', $id)->get();
        foreach($fields as $field){
            $field->user_id = 999;
            $field->save();
        }

        //hapus data field
        $hapus = $user->delete();

        //jika berhasil
        if($hapus){
            return redirect()->route('admin.operator.index', ['status' => 'sukses-hapus']);
        }else{
            return redirect()->route('admin.operator.index', ['status' => 'gagal-hapus']);
        }
    }
}
