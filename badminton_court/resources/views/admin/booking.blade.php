@extends('layouts.auth.app')
@section('title', 'Dashboard')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Booking Lapangan</h1>
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
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Daftar Data Booking Lapangan</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama</th>
						<th>Lapangan</th>
						<th>Kategori</th>
						<th>Tanggal</th>
						<th>Jam</th>
                        <th>Biaya</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
                ?>
                @foreach ($booking_lapangan as $data)
                    <?php
                        $jam = $data->start_time . ' - ' . $data->end_time;
                        //total jam dari start_time dan end_time
                        $start_time = new DateTime($data->start_time);
                        $end_time = new DateTime($data->end_time);
                        $diff = $start_time->diff($end_time);
                        $total_jam = $diff->h;
                        $biaya = $total_jam * $data->field->price;
                    ?>
                    <tr align="center">
						<td><?php echo $no; ?></td>
						<td><?php echo $data->user->name; ?></td>
						<td><?php echo $data->field->name; ?></td>
						<td><?php echo $data->field->category->name; ?></td>
						<td><?php echo $data->date; ?></td>
						<td><?php echo $jam; ?></td>
                        <td><?php echo 'Rp ' . number_format($biaya,0,',','.'); ?></td>
					</tr>
					<?php
					$no++;?>
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
