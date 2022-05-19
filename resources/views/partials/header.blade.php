{{--
    /**
     * Header partial, injected in master layout
     *
     * @package Academy Management Software
     * @author DataTrix Team
     */
--}}
<!-- Main Header -->
<header id="dt-Head" class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">JRR</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Jannat RR</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="javascript:;" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav navbar-left hidden-xs">
                <li id="dt-DateTime">
                    <a href="javascript:;">
                        <span style="margin-right: 5px;">@{{ day }}, @{{ date }}</span>
                        <span>@{{ time }}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav">                    
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ URL::asset('assets/images/avatar-male.png') }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears.
                        -->
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ URL::asset('assets/images/avatar-male.png') }}" class="img-circle" alt="User Image">
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('users.profile',Auth::user()->id) }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}"
                                   class="btn btn-default btn-flat">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>