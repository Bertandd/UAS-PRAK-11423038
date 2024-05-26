<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

      <div class="sidebar-brand-text mx-3">MENU</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->is('operator/dashboard*')) active @endif">
        <a class="nav-link" href="{{ route('operator.dashboard') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider mb-2">
    <li class="nav-item @if (request()->is('operator/member*')) active @endif">
        <a class="nav-link" href="{{ route('operator.member.index') }}">
            <i class="align-middle fa fa-users"></i>
            <span class="align-middle">Kelola Member</span>
        </a>
    </li>
        <li class="nav-item @if (request()->is('operator/field*')) active @endif">
            <a class="nav-link" href="{{ route('operator.field.index') }}">
                <i class="align-middle fa fa-globe"></i> <span class="align-middle">Kelola Lapangan</span>
            </a>
        </li>
        <li class="nav-item @if (request()->is('operator/booking*')) active @endif">
            <a class="nav-link" href="{{ route('operator.booking.index') }}">
                <i class="align-middle fa fa-calendar"></i> <span class="align-middle">Data Booking</span>
            </a>
        </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->
