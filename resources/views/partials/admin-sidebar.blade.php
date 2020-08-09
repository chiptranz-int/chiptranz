<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">

                <span class="menu-title"></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('dashboard/')}}">
                <i class="mdi mdi-airplay menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('customers/')}}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Customers</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
               aria-controls="form-elements">
                <i class="mdi mdi-chart-bar menu-icon"></i>
                <span class="menu-title">Plans</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{url('plans/youths?item=all')}}">Youth Goals</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('plans/steady?item=all')}}">Steady Growth</a></li>

                </ul>
            </div>
        </li>


    </ul>
</nav>