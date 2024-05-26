@extends('layouts.auth.app')
@section('title', 'Dashboard')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Booking Lapangan</h1>
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
    case 'waktu-tidak-valid':
        $msg = 'Waktu tidak valid, silahkan pilih waktu lain';
        break;
    case 'jadwal-bentrok':
        $msg = 'Jadwal bentrok, silahkan pilih waktu lain';
        break;
    case 'data-disabled':
     $msg = "Data tidak bisa diedit";
endswitch;

if($msg):
	echo '<div class="alert alert-info">'.$msg.'</div>';
endif;

?>
<div class="card shadow mb-4">
	<form action="{{ route('user.booking.store', $field->id) }}" method="POST">
        @csrf
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Lapangan</label>
					<select name="field_id" required class="form-control">
						<option value="">Pilih Lapangan</option>
						@foreach ($fields as $data)
                            <?php
                            $selected = ($data->id == $field->id) ? 'selected' : '';
							//hanya tampilkan yang selected
                            if($selected):
                            ?>
                                <option value="{{ $data->id }}" {{ $selected }}>{{ $data->name }}</option>
                            <?php
                            endif;
                            ?>
                        @endforeach
					</select>
				</div>
				<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Tanggal</label>
					<input type="date" name="date" required class="form-control" value="{{ $date }}" min="{{ date('Y-m-d') }}">
				</div>
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Waktu Mulai</label>
					<select name="start_time" required class="form-control" id="start_time">
                        <?php
                            $jam = array('08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00');
                            // buat jam array mulai dari waktu buka sampai waktu 1 jam sebelum tutup
                            $jam = array_slice($jam, array_search($data->open, $jam), array_search($data->close, $jam) - array_search($data->open, $jam));
                            //hilangkan 00 di belakang jam
                            $jam = array_map(function($val) {
                                return substr($val, 0, 5);
                            }, $jam);
                        ?>
                        @foreach ($jam as $data)
                            <option value="{{ $data }}" {{ $start == $data ? 'selected' : '' }}>{{ $data }}</option>
                        @endforeach
					</select>
				</div>
				<div class="form-group col-md-6">
					<label class="font-weight-bold">Waktu Selesai</label>
					<select name="end_time" required class="form-control" id="end_time">
						@foreach ($jam as $data)
                            {{-- minimal 2 jam --}}
                            @if($data > $start && $data >= $end)
                                <option value="{{ $data }}" {{ $end == $data ? 'selected' : '' }}>{{ $data }}</option>
                            @endif
                        @endforeach
					</select>
				</div>
                {{-- tampilkan label harga --}}
                <div class="form-group col-md-12">
                    <p class="mb-1" id="perjamnya">Harga perjam: <strong>Rp. {{ number_format($field->price, 0, ',', '.') }}</strong></p>
                    <p class="mb-1">Total biaya: <strong>Rp. <span id="perjam">{{ number_format($field->price, 0, ',', '.') }}</span> x <span id="total_jam">2</span> jam = <span id="total_biaya">Rp. {{ number_format($field->price * 2, 0, ',', '.') }}</span></strong></p>
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
    $(document).ready(function() {
        var jam = [];
        @foreach ($jam as $data)
            jam.push('{{ $data }}');
        @endforeach
        $('#start_time').change(function() {
            var start_time = $(this).val();
            $('#end_time').html('');

            //waktu selesai harus lebih besar dari waktu mulai dan harus minimal 2 jam
            for (let i = 0 + 1; i < jam.length; i++) {
                if(jam.indexOf(jam[i]) >= jam.indexOf(start_time) + 2) {
                    $('#end_time').append('<option value="'+jam[i]+'">'+jam[i]+'</option>');
                }
            }

            //hitung total biaya, total jam dari selisih index
            var total_jam = jam.indexOf($('#end_time').val()) - jam.indexOf(start_time);
            $('#total_jam').html(total_jam);
            $('#total_biaya').html('Rp. ' + ({{ $field->price }} * total_jam).toLocaleString('id'));

        });
        $('#end_time').change(function() {
            var total_jam = jam.indexOf($(this).val()) - jam.indexOf($('#start_time').val());
            $('#total_jam').html(total_jam);
            $('#total_biaya').html('Rp. ' + ({{ $field->price }} * total_jam).toLocaleString('id'));
        });
    });
</script>
@endsection
