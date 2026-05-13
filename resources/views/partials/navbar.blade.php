<nav class="app-header navbar navbar-expand fixed-top bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow"
                         alt="User Image">
                    <span class="d-none d-md-inline">{{Auth::user()->nama_user}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow"
                             alt="User Image">
                        <p>
                            {{Auth::user()->nama_user}} - {{strtoupper(Auth::user()->role)}}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('akun.index') }}" class="btn btn-default btn-flat">Pengaturan
                            Akun</a>
                        <a href="#"
                           onclick="konfirmasiLogout(event)"
                           class="btn btn-default btn-flat float-end">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </div>
</nav>
