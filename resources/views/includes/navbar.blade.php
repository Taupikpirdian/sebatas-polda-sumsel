<header id="page-topbar">
  <div class="navbar-header">
      <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
              <a href="{{URL::to('/')}}" class="logo logo-dark">
                  <span class="logo-sm">
                      <img src="{{asset('assets/images/logo-poldasumsel.png')}}" alt="" height="60">
                      <img src="{{asset('assets/images/logo-bareskrim.png')}}" alt="" height="60">
                      <img src="{{asset('assets/images/maskot.png')}}" alt="" height="60">
                  </span>
                  <span class="logo-lg">
                      <img src="{{asset('assets/images/logo-poldasumsel.png')}}" alt="" height="60">
                      <img src="{{asset('assets/images/logo-bareskrim.png')}}" alt="" height="60">
                      <img src="{{asset('assets/images/maskot.png')}}" alt="" height="60">
                  </span>
              </a>

              <a href="{{URL::to('/')}}" class="logo logo-light">
                  <span class="logo-sm">
                      <img src="{{asset('assets/images/logo-poldasumsel.png')}}" alt="" height="60">
                  </span>
                  <span class="logo-lg">
                      <img src="{{asset('assets/images/logo-poldasumsel.png')}}" alt="" height="60">
                  </span>
              </a>
          </div>

          <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
              <i class="mdi mdi-backburger"></i>
          </button>
      </div>

      <div class="d-flex">

          <div class="dropdown d-inline-block">
              <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="Header Avatar">
                  <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->name }}</span>
                  <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
              </div>
          </div>

      </div>
  </div>
</header>