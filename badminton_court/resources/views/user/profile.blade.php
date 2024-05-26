@extends('layouts.auth.app')
@section('title', 'Dashboard')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Profile</h1>
</div>

<?php
$status = session('status');
$msg = '';
switch($status):
	case 'sukses-baru':
		$msg = 'Data berhasil disimpan';
		break;
	case 'sukses-hapus':
		$msg = 'Data behasil dihapus';
		break;
	case 'sukses-edit':
		$msg = 'Data behasil diupdate';
		break;
endswitch;

if($msg):
	echo '<div class="alert alert-info">'.$msg.'</div>';
endif;

?>


<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Ubah Data</h6>
    </div>
    <form action="{{ route('profile.update')}}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Email</label>
                    <input autocomplete="off" type="text" name="email" required value="{{$profile->email}}" class="form-control"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nama</label>
                    <input autocomplete="off" type="text" name="name" required value="{{$profile->name}}" class="form-control"/>
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Password (Kosongkan jika tidak ingin mengganti)</label>
                    <input autocomplete="off" type="password" name="password" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
            <button type="reset" class="btn btn-success"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script>
        //datatable
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
