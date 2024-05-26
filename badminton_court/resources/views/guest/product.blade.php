@extends('layouts.my_layout')
@section('title', 'Home')
@section('content')
<div class="container" style="min-height: 80vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-white"><i class="fas fa-fw fa-futbol"></i> Produk Tersedia :</h1>
    </div>
    <div class="alert alert-danger">
        <div class="font-weight-bold"><i class="fa fa-clock"></i> <span id="clock"></span></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('guest.product.category') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group
                                        ">
                                            <select name="filter" class="form-control">
                                                <option value="00">Semua Kategori</option>
                                                @foreach($categories as $data)
                                                <option value="{{ $data->id }}" {{ $filter == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            @foreach ($product as $data)
                            <?php
                            //maksimal detail
                            $deskripsi = substr($data->description, 0, 100);
                            //harga
                            $harga = number_format($data->price,0,',','.');
                            ?>
                            <div class="clearfix mt-3"></div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="{{ url('storage/product/'.$data->image) }}" class="card-img-top" alt="{{ $data->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold mb-0">{{ $data->name }}</h5>
                                        <p class="card-text text-info font-weight-bold mb-0">Rp. {{$harga}}</p>
                                        <p class="card-text text-info font-weight-bold mb-0">Kategori : {{ $data->category->name }}</p>
                                        <p class="card-text">{{ $deskripsi }}</p>
                                        <a href="{{route('user.booking-product', $data->id)}}" class="btn btn-primary">Booking</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        {{ $product->links() }}
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


