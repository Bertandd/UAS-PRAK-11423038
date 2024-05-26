<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

      <div class="sidebar-brand-text mx-3">MENU</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->is('admin/dashboard*')) active @endif">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider mb-2">
    <li class="nav-item @if (request()->is('admin/operator*')) active @endif">
        <a class="nav-link" href="{{ route('admin.operator.index') }}">
            <i class="align-middle fa fa-users"></i>
            <span class="align-middle">Kelola Pengurus</span>
        </a>
    </li>
        <li class="nav-item @if (request()->is('admin/field-locations*')) active @endif">
            <a class="nav-link" href="{{ route('admin.field-locations.index') }}">
                <i class="align-middle fa fa-map-marker"></i> <span class="align-middle">Lokasi Lapangan</span>
            </a>
        </li>
        <li class="nav-item @if (request()->is('admin/report*')) active @endif">
            <a class="nav-link" href="{{ route('admin.report.index') }}">
                <i class="align-middle fa fa-file"></i> <span class="align-middle">Report</span>
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
