<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPENGOLAH Limbah B3 Login</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <a href="./" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover text-decoration-none">
                    <h1 class="mb-0">SIPENGOLAH Limbah B3</h1>
                </a>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">APLIKASI SIPENGOLAH LIMBAH B3</p>

                <form action="{{route('login.post')}}" method="post">
                    @csrf
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="loginEmail" type="text" class="form-control" name="username" required
                                placeholder="" />
                            <label for="loginEmail">Username</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="loginPassword" type="password" class="form-control" name="password" required
                                placeholder="" />
                            <label for="loginPassword">Password</label>
                        </div>
                        <div class="input-group-text" id="togglePasswordBtn" style="cursor: pointer;">
                            <span id="togglePasswordIcon" class="bi bi-eye-slash"></span>
                        </div>
                    </div>
                    <!--begin::Row-->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 mt-2">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <div class="col-3 mt-4">
        <p class="login-box-msg">
            UPT Pengelolaan Limbah Bahan Berbahaya dan Beracun
            Dinas Pengelolaan Lingkungan Hidup (DPLH) <br>
            Pemerintah Provinsi Sulawesi Selatan<br>
            Copyright @ 2020 – 2021. Hak Cipta Dilindungi
        </p>
    </div>
    <!-- /.login-box -->

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login!',
                    text: '{!! $errors->first() !!}',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Coba Lagi'
                });
            });
        </script>
    @endif
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

            // Disable OverlayScrollbars on mobile devices to prevent touch interference
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }

            // Toggle password visibility
            const passwordInput = document.getElementById('loginPassword');
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        togglePasswordIcon.classList.remove('bi-eye-slash');
                        togglePasswordIcon.classList.add('bi-eye');
                    } else {
                        passwordInput.type = 'password';
                        togglePasswordIcon.classList.remove('bi-eye');
                        togglePasswordIcon.classList.add('bi-eye-slash');
                    }
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
</body>
<!--end::Body-->

</html>