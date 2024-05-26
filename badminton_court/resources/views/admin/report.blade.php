@extends('layouts.auth.app')
@section('title', 'Data Report')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Report</h1>
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
        <h5 class="m-0 font-weight-bold text-info text-center">Laporan Penyewaan Lapangan</h5>
        <h6 class="m-0 font-weight-bold text-info text-center">Periode: <?php echo date('d M Y', strtotime($start_date)); ?> s/d <?php echo date('d M Y', strtotime($end_date)); ?></h6>
    </div>
    <div class="card-body">
        {{-- filter tanggal --}}
        <form action="{{ route('admin.report.filter') }}" method="POST" class="mb-2">
            @csrf
            <div class="row">
                <p class="col-md-12">Filter Tanggal:</p>
                <div class="col-md-4">
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                </div>
                <div class="col-md-4">
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                </div>
                <div class="col-md-4">
                    <div class="row pr-3">
                        <button type="submit" class="btn btn-info col-6">Filter</button>
                        <a href="#" id="exportBtn" class="btn btn-danger col-5 ml-2">Export</a>
                    </div>
                </div>
            </div>
        </form>
		<div class="table-responsive">
			<table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Lapangan</th>
                        <th>Lokasi</th>
                        <th>Jam</th>
                        <th>Biaya</th>
                        <th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				?>
                @foreach ($booking_lapangan as $data)
                <?php
                 $jam = $data->start_time . ' - ' . $data->end_time;
                 $start_time = new DateTime($data->start_time);
                    $end_time = new DateTime($data->end_time);
                    $diff = $start_time->diff($end_time);
                    $total_jam = $diff->h;
                    $biaya = $total_jam * $data->field->price;
                ?>
                <tr align="center">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data->date; ?></td>
                    <td><?php echo $data->user->name; ?></td>
                    <td><?php echo $data->field->name; ?></td>
                    <td><?php echo $data->field->fieldLocation->name; ?></td>
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
                        echo '<small>';
                        if($data->status == 'pending'){
                            echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                        }elseif($data->status == 'approved'){
                            echo '<span class="badge badge-success">Disetujui</span>';
                        }elseif($data->status == 'rejected'){
                            echo '<span class="badge badge-danger">Ditolak</span>';
                        }
                        echo '</small>';
                        ?>
                    </td>
                </tr>
                <?php
                $jam = $data->waktu_mulai.'-'.$data->waktu_selesai;
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
            $('#exportBtn').click(function(){
                //buat agar kirim post
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '{{ route('admin.report.export') }}';
                //tambahkan csrf token
                var csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                //buat input
                var start_date = document.createElement('input');
                start_date.name = 'start_date';
                start_date.value = $('#start_date').val();
                form.appendChild(start_date);
                var end_date = document.createElement('input');
                end_date.name = 'end_date';
                end_date.value = $('#end_date').val();
                form.appendChild(end_date);
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
@endsection
