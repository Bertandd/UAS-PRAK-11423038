@extends('layouts.auth.app')
@section('title', 'Tambah Lapangan')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Tambah Lapangan</h1>
	<a href="{{ route('operator.field.index') }}" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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

<?php if(session('status')): ?>
	<div class="alert alert-info">
		<?php echo session('status'); ?>
	</div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-fw fa-plus"></i> Tambah Data Lapangan</h6>
    </div>

	<form action="{{ route('operator.field.store') }}" method="post" enctype="multipart/form-data">
        @csrf
		<div class="card-body">
			<div class="row">
                <input type="hidden" name="field_location_id" value="{{ Auth::user()->fieldLocations->first()->id }}">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama Lapangan</label>
					<input autocomplete="off" type="text" name="name" required class="form-control" value="{{ old('name') }}"/>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Harga</label>
					<div class="input-group">
                        <input autocomplete="off" type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="Default 55000"/>
                        <div class="input-group-append">
                            <span class="input-group-text">/ Jam</span>
                        </div>
                    </div>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
				</div>
			</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Jam Buka</label>
                    <input autocomplete="off" type="time" name="open" required class="form-control" value="{{ old('open') }}"/>
                    @error('open')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Jam Tutup</label>
                    <input autocomplete="off" type="time" name="close" required class="form-control" value="{{ old('close') }}"/>
                    @error('close')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Syarat & Ketentuan</label>
					<textarea name="description" required class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Gambar</label>
					<input autocomplete="off" type="file" name="image" required class="form-control" accept="image/*"/>
                    @error('image')
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
