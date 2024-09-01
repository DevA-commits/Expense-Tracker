<style>
    #current-time {
        font-size: 1rem;
        font-weight: bold;
        color: #ffffff;
        background-color: rgb(255, 68, 68);
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        height: 31px;
        padding: 5px 10px;
        margin-top: 19.5px;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    #page-topbar {
        /* background-image: url("https://wallpapers.com/images/hd/simplicity-in-identity-minimalist-gradient-eqios7qpexr27fj8.jpg"); */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ url('/') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ url('assets/images/logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ url('assets/images/logo.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <a href="{{ url('/') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ url('assets/images/logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ url('assets/images/logo.png') }}" alt="" height="17">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <div id="current-time">
                    <!-- Time will be displayed here -->
                </div>
            </div>
            <div class="d-flex align-items-center">




                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" id="fullscreencus"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="https://ui-avatars.com/api/?background=5585EE&color=fff&name="
                                alt="">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">super
                                    admin</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a class="dropdown-item" href=""><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        
                        
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item" href="#"><i
                                class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        
                        <a class="dropdown-item" href=""><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                        <form id="logout-form" action="#" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        const options = {
            timeZone: 'Asia/Kolkata',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const formattedTime = now.toLocaleTimeString('en-US', options);

        timeElement.textContent = `IST ${formattedTime}`;
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    // Initial call to display the time immediately on page load
    updateTime();
</script>
