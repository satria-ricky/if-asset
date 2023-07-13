<div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message"> {{ Auth::user()->username }} </span>
                        </li>
                        <li class="dropdown">
                            {{-- <a class=" count-info" href="/profil">
                                <i class="fa fa-user"></i> Profil
                            </a> --}}
                            {{-- <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-user fa-fw"></i> Profil
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="profile.html" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="float-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="grid_options.html" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="float-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="notifications.html" class="dropdown-item">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul> --}}
                        </li>


                        <li>
                            {{-- <a href="/logout">
                                <i class="fa fa-sign-out"></i> Keluar
                            </a> --}}
                            <form action="{{route('logout')}}" method="get">
								@csrf
                                <button type="submit" class="btn btn-outline btn-link" onclick="return confirm('Are you sure?')"><i class="fa fa-sign-out"></i> Keluar</button>

							</form>

                        </li>
                    </ul>

                </nav>
            </div>