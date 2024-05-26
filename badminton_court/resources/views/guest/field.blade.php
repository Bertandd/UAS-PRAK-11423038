@extends('layouts.my_layout')
@section('title', 'Home')
@section('content')

<div class="container" style="min-height: 80vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-white"><i class="fas fa-fw fa-futbol"></i> Lapangan Tersedia :</h1>
    </div>
    <div class="alert alert-danger my-bg">
        <div class="font-weight-bold text-white"><i class="fa fa-clock"></i> <span id="clock" class=""></span></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('guest.field.location') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group
                                        ">
                                            <label for="filter" class="font-weight-bold">Filter Lokasi</label>
                                            <select name="filter" class="form-control">
                                                <option value="00">Semua Lokasi</option>
                                                @foreach($locations as $data)
                                                <option value="{{ $data->id }}" {{ $filter == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- filter jam --}}
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="filter" class="font-weight-bold">Filter Waktu </label>
                                            <div class="input-group">
                                                {{-- tanggal disable tanggal sebelumnya--}}
                                                <input type="date" name="date" class="form-control" value="{{ $date }}" min="{{ date('Y-m-d') }}">
                                                {{-- jam --}}
                                                <input type="time" name="start" class="form-control" value="{{ $start }}">
                                                <span class="input-group-text">-</span>
                                                <input type="time" name="end" class="form-control" value="{{ $end }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- opsi tampilkan lapangan kosong atau semua --}}
                                    <div class="col-md-3">
                                        <div class="form-group mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check form-check-input" type="checkbox" name="empty" id="empty" {{ $empty == 'on' ? 'checked' : '' }}>
                                                <label class="form-check form-check-label" for="empty"><small>Tampilkan Hanya Lapangan Kosong</small></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <button type="submit" class="btn btn-primary col-12">Terapkan Filter</button>
                                    </div>
                                </div>
                            </form>
                            {{-- clearfix --}}
                            <div class="row mt-2">
                                @foreach ($field as $data)
                                <?php
                                //maksimal detail
                                $deskripsi = substr($data->description, 0, 100);
                                //harga
                                $harga = number_format($data->price,0,',','.');
                                ?>
                                <div class="col-md-4 col-lg-4">
                                    <div class="card mb-4 h-100 position-relative">
                                        <img src="{{ url('storage/field/'.$data->image) }}" class="card-img-top" alt="{{ $data->name }}" height="300px">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-info text-white">Rp. {{$harga}}</span>
                                            {{-- jam buka - tutup --}}
                                            <span class="badge bg-dark text-white">{{ $data->open }} - {{ $data->close }}</span>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold mb-0">{{ $data->name }}</h5>
                                            <p class="card-text text-info font-weight-bold mb-0">Lokasi : {{ $data->fieldLocation->name }}</p>
                                            <p class="card-text">{{ $deskripsi }}</p>
                                            {{-- <a href="{{route('user.booking', $data->id)}}" class="btn btn-primary col-12">Booking</a> --}}
                                            {{-- tombol menampilkan data booking dropdown --}}
                                            <a href="#" class="btn btn-info col-12 mt-2" data-bs-toggle="collapse" data-bs-target="#collapseExample{{ $data->id }}" aria-expanded="false" aria-controls="collapseExample{{ $data->id }}">Lihat Data Booking</a>
                                            {{-- data booking --}}
                                            <div class="collapse mt-2" id="collapseExample{{ $data->id }}">
                                                <?php
                                                $jam = array('08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00');
                                                // buat jam array mulai dari waktu buka sampai waktu 1 jam sebelum tutup
                                                $jam = array_slice($jam, array_search($data->open, $jam), array_search($data->close, $jam) - array_search($data->open, $jam));
                                                ?>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        @foreach ($jam as $j)
                                                        <?php
                                                        // cek apakah jam sudah lewat
                                                        $now = date('Y-m-d H:i:s');
                                                        $now = strtotime($now);
                                                        //waktu sekarang $j ditambahkan ke tanggal $date
                                                        $j = strtotime($date.' '.$j);
                                                        $time = date('H:i:s', $j);

                                                        $booked = \App\Models\FieldBooking::where('field_id', $data->id)->where('date', $date)->where('start_time', '<=',$time)->where('status', 'approved')->where('end_time', '>=', $time)->count();
                                                        ?>
                                                                    @if($empty =='on')
                                                                        @if ($now > $j)

                                                                        @elseif ( $booked > 0)

                                                                        @else
                                                                        <div class="col-md-6">
                                                                        <div class="card mb-2">
                                                                            <div class="card-body p-2">
                                                                                <div class="text-center">
                                                                                    <span class="badge bg-info text-white">{{ date('H:i', $j) }}</span>
                                                                                </div>
                                                                                <a href="{{ route('user.booking', ['id' => $data->id, 'date' => $date, 'start' => date('H:i', $j), 'end' => date('H:i', strtotime('+2 hour', $j))]) }}" class="btn btn-primary col-12">Booking</a>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        @endif
                                                                    @else
                                                                    <div class="col-md-6">
                                                                    <div class="card mb-2">
                                                                        <div class="card-body p-2">
                                                                        <div class="text-center">
                                                                            <span class="badge bg-info text-white">{{ date('H:i', $j) }}</span>
                                                                        </div>
                                                                        @if ($now > $j)
                                                                        <button class="btn btn-secondary col-12" disabled>Waktu Habis</button>
                                                                        @elseif ($empty != 'on' && $booked > 0)
                                                                        <button class="btn btn-danger col-12" disabled>Lapangan Terisi</button>
                                                                        @else
                                                                        <a href="{{ route('user.booking', ['id' => $data->id, 'date' => $date, 'start' => date('H:i', $j), 'end' => date('H:i', strtotime('+2 hour', $j))]) }}" class="btn btn-primary col-12">Booking</a>
                                                                        @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        {{ $field->links() }}
                    </div>
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


