@extends('layouts.auth.app')
@section('title', 'Ubah Lokasi Lapangan')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Lokasi Lapangan</h1>

	<a href="{{ route('admin.field-locations.index') }}" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<?php if(!empty(session('status'))): ?>
	<div class="alert alert-info">
		<?php echo session('status'); ?>
	</div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-fw fa-plus"></i> Ubah Data Lokasi Lapangan</h6>
    </div>

	<form action="{{ route('admin.field-locations.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Nama Lokasi</label>
                    <input autocomplete="off" type="text" name="name" required class="form-control" value="{{$data->name}}"/>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Alamat</label>
                    <textarea name="address" required class="form-control">{{$data->address}}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Pengelola</label>
                    <select name="user_id" required class="form-control">
                        <option value="">Pilih Pengelola</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>

</div>
@endsection
@section('script')
    <script>

    </script>
@endsection
