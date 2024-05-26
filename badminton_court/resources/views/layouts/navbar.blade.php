<div class="sticky-top">

    <nav class="shadow my-navbar navbar navbar-expand-lg navbar-dark my-bg py-3">
        <div class="container-fluid">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="col-lg-4 col-sm-4 logo d-flex align-items-center gap-3 mb-3 mb-lg-0 mb-md-0">
                <img src="{{ asset(get_my_app_config('logo')) }}">
                <div class="d-flex flex-column">
                    <h1 class="text-white"><a href="{{ route('home') }}" class="text-decoration-none fw-bold text-white text-uppercase">
                            {!! get_my_app_config('nama_web') !!}</a></h1>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link "
                            href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  @if(request()->is('/') || request()->is('guest/field*')) active @endif"
                            href="{{ route('guest.field') }}">Lapangan</a>
                    </li>
                    @if (Auth::check())
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link ">Keluar</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link  @if(request()->is('login')) active @endif"
                            href="{{ route('login') }}">Masuk</a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>


</div>
