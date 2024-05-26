<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    @if(auth()->user()->role == 'admin')
                        <img src="{{ asset('img/avatars/person1.png') }} " class="avatar img-fluid rounded me-1" />
                    @else
                        <img src="{{ asset('img/avatars/person2.png') }} " class="avatar img-fluid rounded me-1" />
                    @endif
                    <span class="text-dark fw-bold">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="align-middle me-1"
                            data-feather="user"></i> Profile</a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Log out</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
