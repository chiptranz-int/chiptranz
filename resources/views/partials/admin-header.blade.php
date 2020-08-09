<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-primary">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{@asset('/chiptranz-vendors/images/logo.svg')}}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{@asset('/chiptranz-vendors/images/logo-mini.svg')}}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown bg-warning rounded">
                    <a class="dropdown-item text-dark" href="#" onclick="document.querySelector('#logout-form').submit();">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>