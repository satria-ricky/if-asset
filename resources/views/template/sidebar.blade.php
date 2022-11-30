<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" style="width: 120px;" class="rounded-circle image-fluid" src="https://lppm.unram.ac.id/wp-content/uploads/2018/07/LOGO-UNRAM-1.png" />
                            <span class="clear">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="block m-t-xs font-bold">Inventaris Aset IF-UNRAM</span>
                                </a>
                            </span>
                        </div>
                        <div class="logo-element">
                            IF-UNRAM
                        </div>
                    </li>
                    {{-- <li class= {{$loc == 'dashboard' ? "active" : "1"}}>
                        <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li> --}}
                    <li  class="@if(Request::is('list_ruangan')) active @endif">
                        <a href="/list_ruangan"><i class="fa fa-sticky-note"></i> <span class="nav-label">Daftar Ruangan</span></a>
                    </li>
                    <li  class="@if(Request::is('list_aset')) active @elseif(Request::is('edit_aset/*')) active @endif">
                        <a href="/list_aset"><i class="fa fa-sticky-note"></i> <span class="nav-label">Daftar Aset</span></a>
                    </li>
                </ul>

            </div>
        </nav>