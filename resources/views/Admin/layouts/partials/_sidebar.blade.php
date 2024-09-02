<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ url('assets/images/MyEXP.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ url('assets/images/MyEXP.png') }}" alt="" height="100">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ url('assets/images/MyEXP.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">

                <img src="{{ url('assets/images/MyEXP.png') }}" alt="" height=110" width="130" class="mt-2">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link @if (Route::currentRouteName() == 'dashboard') active @endif" href="{{ route('dashboard') }}">
                        <i class="ri-funds-box-fill"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Master</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if (Route::currentRouteName() == 'admin.index') active @endif" href="{{ route('admin.index') }}">
                        <i class="ri-bar-chart-box-fill"></i> <span>Expense</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if (Route::currentRouteName() == 'admin.report') active @endif" href="{{ route('admin.report') }}">
                        <i class="ri-file-list-2-fill"></i> <span>Report</span>
                    </a>
                </li>


                <!-- <li class="menu-title"><span>Setting</span></li> -->

            </ul>





        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>