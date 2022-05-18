<div class="vertical-menu">

  <div data-simplebar class="h-100">

      <!--- Sidemenu -->
      <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            @if(Auth::user()->groups()->where("name", "=", "Admin")->first())
            <li class="menu-title">Master Data</li>
            <li>
                <a href="{{URL::to('/jenis-pidana/index')}}" class=" waves-effect">
                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-table"></i></div>
                    <span>Jenis Tindak Pidana</span>
                </a>
            </li>
            <li>
              <a href="{{URL::to('/jenis-narkoba/index')}}" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-table"></i></div>
                  <span>Jenis Narkoba</span>
              </a>
            </li>
            {{-- <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-padlock"></i></div>
                    <span>Role</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{URL::to('/group-roles')}}">Group Roles</a></li>
                    <li><a href="{{URL::to('/user-groups')}}">User Groups</a></li>
                </ul>
            </li> --}}
            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-at"></i></div>
                  <span>User</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li><a href="{{URL::to('/user/index')}}">Tambah User</a></li>
                  <li><a href="{{URL::to('/akses/index')}}">Hak Akses User</a></li>
              </ul>
            </li>
            @endif

            <li class="menu-title">Data Kriminal</li>
            <li>
              <a href="#" data-toggle="modal" data-target="#modal-default" class="ai-icon" aria-expanded="false" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-table"></i></div>
                  <span>Data Kasus</span>
              </a>
            </li>
            @if(Auth::user()->groups()->where("name", "!=", "Admin")->first())
            <li>
              <a href="{{URL::to('/perkara/create')}}" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-document-layout-left"></i></div>
                  <span>Tambah Kasus</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->groups()->where("name", "=", "Admin")->first())
            <li class="menu-title">Report</li>
            <li>
              <a href="{{URL::to('/logs')}}" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-table"></i></div>
                  <span>Aktivitas/Logs</span>
              </a>
            </li>
            <li>
              <a href="{{URL::to('/rekapitulasi')}}" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-chart"></i></div>
                  <span>Rekapitulasi Kasus</span>
              </a>
            </li>
            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-bag"></i></div>
                  <span>POLDA</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li>
                    <a href="#" data-toggle="modal" data-target="#modal-polda" class="ai-icon" aria-expanded="false" class=" waves-effect">
                      <span>Dashboard Polda</span>
                    </a>
                  </li>
                  <li><a href="{{URL::to('/rekapitulasi?mode=polda')}}">Rekapitulasi Kasus Divisi</a></li>
              </ul>
            </li>
            <li>
              <a href="#" data-toggle="modal" data-target="#modal-polres" class="ai-icon" aria-expanded="false" class=" waves-effect">
                  <div class="d-inline-block icons-sm mr-1"><i class="uim uim-bag"></i></div>
                  <span>POLRES</span>
              </a>
            </li>
            @elseif(Auth::user()->groups()->where("name", "=", "Polres")->first())
              @if(Auth::user()->divisi != 'Satpolaires')
              <li>
                  <a href="{{URL::to('/polsek/list-satker')}}" class=" waves-effect">
                      <div class="d-inline-block icons-sm mr-1"><i class="uim uim-bag"></i></div>
                      <span>POLSEK</span>
                  </a>
              </li>
              @endif
            @endif
          </ul>
      </div>
      <!-- Sidebar -->
  </div>
</div>