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
                    
                    {{-- <li class="@if(Request::is('list_ruangan')) active @elseif(Request::is('list_jurusan')) active @endif">
                        <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Lokasi </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="/list_jurusan">Jurusan</a></li>
                            <li><a href="/list_ruangan">Ruangan</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="@if(Request::is('list_ruangan')) active @elseif(Request::is('list_jurusan')) active @endif">
                        <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Lokasi </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="/list_jurusan">Jurusan</a></li>
                            <li><a href="/list_ruangan">Ruangan</a></li>
                        </ul>
                    </li> --}}
                    
                    <li  class="@if(Request::is('list_ruangan')) active @endif">
                        <a href="/list_ruangan"><i class="fa fa-home"></i> <span class="nav-label">Ruangan</span></a>
                    </li>

                    <li class="@if(Request::is('list_aset')) active @elseif(Request::is('edit_aset/*')) active @elseif(Request::is('list_jenis_aset')) active @endif">
                        <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Aset </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="/list_jenis_aset">Jenis Aset</a></li>
                            <li><a href="/list_aset">Daftar Aset</a></li>
                        </ul>
                    </li>

                    
                    <li  class="@if(Request::is('list_laporan')) active @elseif(Request::is('adm_laporan/*')) active @endif">
                        <a href="/list_laporan"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan</span></a>
                    </li>
                    
                    <li class="@if(Request::is('histori_aset')) active @elseif(Request::is('histori_ruangan')) active @endif">
                        <a href="#"><i class="fa fa-history"></i> <span class="nav-label">Histori </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="/histori_ruangan">Penggunaan Ruangan</a></li>
                            <li><a href="/histori_aset"> Penggunaan Aset</a></li>
                        </ul>
                    </li>

                    {{-- <li  class="@if(Request::is('adm_histori')) active @endif">
                        <a href="/adm_histori"><i class="fa fa-history"></i> <span class="nav-label">Histori </span></a>
                    </li> --}}
                </ul>

            </div>
        </nav>