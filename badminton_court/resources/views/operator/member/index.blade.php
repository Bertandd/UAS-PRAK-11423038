@extends('layouts.auth.app')
@section('title', 'Kelola Member')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Member</h1>

    <a href="{{ route('operator.member.create') }}" class="btn btn-info"> <i class="fa fa-plus"></i> Tambah Data </a>
</div>
<?php
$status = $_GET['status'] ?? '';
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
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Daftar Data Member</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				?>
                @foreach ($datas as $data)
                <tr align="center">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data->name; ?></td>
                    <td><?php echo $data->email; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="{{ route('operator.member.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                            <a  data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="#" onclick="event.preventDefault(); if(confirm ('Apakah anda yakin untuk menghapus data ini?')) document.getElementById('delete-form-{{ $data->id }}').submit();" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>

                            <form id="delete-form-{{ $data->id }}" action="{{ route('operator.member.destroy', $data->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                <?php
                $no++;
                ?>
                @endforeach
				</tbody>
			</table>
		</div>
	</div>
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
