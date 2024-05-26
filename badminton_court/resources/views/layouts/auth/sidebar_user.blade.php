<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

      <div class="sidebar-brand-text mx-3">MENU</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->is('user/dashboard*')) active @endif">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>
    <hr class="sidebar-divider">
    <li class="nav-item @if (request()->is('field*')) active @endif">
    <a class="nav-link" href="{{ route('guest.field') }}">
        <i class="fas fa-fw fa-futbol"></i>
        <span>Lapangan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
    Riwayat Booking
    </div>
    <li class="nav-item @if (request()->is('user/booking*')) active @endif">
    <a class="nav-link" href="{{ route('user.booking-history') }}">
        <i class="fas fa-fw fa-clock"></i>
        <span>Booking Lapangan</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->
