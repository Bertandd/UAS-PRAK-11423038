@extends('layouts.my_layout')
@section('title', 'Home')
@section('content')
<div class="container" style="min-height: 80vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-white"><i class="fas fa-fw fa-futbol"></i> Lapangan Tersedia :</h1>
    </div>
    <div class="alert alert-danger">
        <div class="font-weight-bold"><i class="fa fa-clock"></i> <span id="clock"></span></div>
    </div>
    <div class="row">
        @foreach ($pengumuman as $data)
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <?php $url = url('storage/announcement/'.$data->image); ?>
                        <div class="card-header" style="background-image: url('{{$url}}'); background-size: cover; min-height: 100px; position: relative;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;">
                                <span class="h3 font-weight-bold" style="color: white; text-align: center;"><?php echo $data->title; ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-0">Deskripsi:</p>
                            <p class="card-text mb-0"><?php echo $data->content; ?></p>
                            <p class="card-text"><small class="text-muted">Waktu Mulai: <?php echo $data->start_date; ?> - Waktu Selesai: <?php echo $data->end_date; ?></small></p>
                            <hr>
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGambar<?php echo $data->id; ?>">Lihat Gambar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalGambar<?php echo $data->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalGambarLabel<?php echo $data->id; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="{{$url}}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    {{ $pengumuman->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
	function updateClock() {
            var clock = document.getElementById('clock');
            var date = new Date();
            var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
            clock.innerHTML = date.toLocaleDateString('id-ID', options);
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Initial update
        updateClock();
</script>
@endpush


