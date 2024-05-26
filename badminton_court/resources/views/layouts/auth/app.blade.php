<!DOCTYPE html>
<html lang="en">
<?php $root = "booking"; ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="{{ asset(get_my_app_config('favicon')) }}" type="image/x-icon">

  <title>{{ get_my_app_config('nama_web') }}</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
     @if (auth()->user()->role == 'admin')
        @include('layouts.auth.sidebar_admin')
    @elseif (auth()->user()->role == 'user')
        @include('layouts.auth.sidebar_user')
    @elseif (auth()->user()->role == 'operator')
        @include('layouts.auth.sidebar_operator')
    @endif
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
		  <button id="sidebarToggleTop" class="btn text-info d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
        <!-- Sidebar - Brand -->
        <?php
        if(auth()->user()->role == 'admin')
            $role = 'Administator';
        elseif(auth()->user()->role == 'user')
            $role = 'User';
        elseif(auth()->user()->role == 'operator')
            $role = 'Operator';
        ?>
        <p class="h5 text-info font-weight-bold mt-3" href="{{ route('admin.dashboard') }}">Panel {{$role}} {{ get_my_app_config('nama_web') }}</p>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-uppercase mr-2 d-none d-lg-inline text-gray-600 small"> {{ Auth::user()->name }} </span>
                <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

		<div class="container-fluid">
            @yield('content')
            @include('layouts.auth.footer')
        </div>

        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/js/demo/datatables-demo.js') }}"></script>
        {{-- select2js cdn--}}

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @yield('script')

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
            </script>
    </div>
</div>
</div>
</body>
</html>


