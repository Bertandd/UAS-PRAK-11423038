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
        case 'data-disabled':
     $msg = "Data tidak bisa diedit";
endswitch;

if($msg):
	echo '<div class="alert alert-info">'.$msg.'</div>';
endif;

?>


<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Riwayat Data Booking Lapangan</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>No</th>
						<th>Nama</th>
						<th>Lapangan</th>
						<th>Lokasi</th>
						<th>Tanggal</th>
						<th>Jam</th>
                        <th>Biaya</th>
                        <th>Status</th>

					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
                ?>
                @foreach ($booking as $data)
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
						<td><?php echo $data->field->fieldLocation->name; ?></td>
						<td><?php echo $data->date; ?></td>
						<td>
                            <?php
                                echo $jam.' ('.$total_jam.' Jam)';
                                ?>
                        </td>
                        <td><?php
                            //harga perjam * total jam
                            echo '<small><span class="badge badge-info">Rp ' . number_format($data->field->price,0,',','.') . 'x' . $total_jam . ' Jam</span></small><br>';
                            echo '<span class="badge badge-success">Rp ' . number_format($biaya,0,',','.') . '</span>';
                        ?></td>
                        <td>
                            <?php
                            if($data->status == 'pending'){
                                echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                echo '<a href="'.route('user.booking.edit', $data->id).'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>';
                            }elseif($data->status == 'approved'){
                                echo '<span class="badge badge-success">Disetujui</span>';
                            }elseif($data->status == 'rejected'){
                                echo '<span class="badge badge-danger">Ditolak</span>';
                            }
                            ?>
                        </td>
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
