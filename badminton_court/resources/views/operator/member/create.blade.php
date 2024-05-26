@extends('layouts.auth.app')
@section('title', 'Ubah Member')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Member</h1>
	<a href="{{ route('operator.member.index') }}" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-fw fa-plus"></i> Tambah Data Member</h6>
    </div>

	<form action="{{ route('operator.member.store') }}" method="post" enctype="multipart/form-data">
        @csrf
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama Member</label>
					<input autocomplete="off" type="text" name="name" required class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
				</div>
			</div>
			<div class="row">
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Email</label>
                    <input autocomplete="off" type="email" name="email" required class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Password</label>
                    <input autocomplete="off" type="password" name="password" required class="form-control"/>
                    @error('password')
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
