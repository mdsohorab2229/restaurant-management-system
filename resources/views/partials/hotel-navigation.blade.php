{{--
    /**
     * Navigation partial, for sidebar menu, injected in master layout
     *
     * @package Academy Management Software
     * @author DataTrix Team
     */
--}}
<!-- Left side column. contains the logo and sidebar -->
<aside id="dt-Nav" class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Request::is('hotel-dashboard') || Request::is('/hotel-dashboard') ? 'active' : '' }}">
                <a href="{{ route('hotel.dashboard') }}">
                    <i class="fa fa-dashboard text-danger"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- direct sell like pos --}}


            {{-- Guest Manage --}}
            <li class="header">Manage Guest</li>
            <li class="treeview {{ Request::is('guest') || Request::is('guest/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-user text-primary"></i>
                    <span>Guest</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('guest/list') ? 'active' : '' }}">
                        <a href="{{ url('guest/list') }}">All Guest</a>
                    </li>
                 
                </ul>
            </li>

            {{-- Room Manage --}}
            <li class="header">Manage Room</li>
            <li class="treeview {{ Request::is('roomcategory') || Request::is('roomcategory/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-user text-primary"></i>
                    <span>Room</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('roomcategory/list') ? 'active' : '' }}">
                        <a href="{{ url('roomcategory/list') }}">All Category</a>
                    </li>
                    <li class="{{ Request::is('room/list') ? 'active' : '' }}">
                        <a href="{{ url('room/list') }}">All Room</a>
                    </li>
                 
                </ul>
                
            </li>

            {{-- Roombooking Manage --}}
            <li class="header">Room Booking</li>
            <li class="treeview {{ Request::is('roombooking') || Request::is('roombooking/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-user text-primary"></i>
                    <span>Room Booking</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('roombooking/list') ? 'active' : '' }}">
                        <a href="{{ url('roombooking/list') }}">All Booking</a>
                    </li>
                 
                </ul>
            </li>
            <li class="header">Reports</li>
            <li class="treeview {{ Request::is('reports') || Request::is('reports/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-user text-primary"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('reports/payment') ? 'active' : '' }}">
                        <a href="{{ url('reports/payment') }}">Payment Reports</a>
                    </li>
                    <li class="{{ Request::is('reports/guest') ? 'active' : '' }}">
                        <a href="{{ url('reports/guest') }}">Guest Reports</a>
                    </li>
                 
                </ul>
            </li>
            <li class="header">Manage Payments</li>
            <li class="bg-success">
                <a href="javascript:void(0)" style="background-color: rgb(0, 166, 90);" data-toggle="modal" data-target="#guestPayment">
                    <i class="fa fa-money" style="color: rgb(255, 255, 255);"></i>
                    <span style="color: rgb(255, 255, 255);">Payment</span>
                </a>
            </li>

            @if(false)
            {{--Manage User--}}
            <li class="header">Manage Users</li>
            <li class="treeview {{ Request::is('users') || Request::is('users/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-users text-danger"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('users/list') ? 'active' : '' }}">
                        <a href="{{ url('users/list') }}">All Users</a>
                    </li>
                    <li class="{{ Request::is('users/create') ? 'active' : '' }}">
                        <a href="{{ url('users/create') }}">Add User</a>
                    </li>
                </ul>
            </li>
            @endif

            @if(false) {{-- check if user has permissions for settings --}}
            <li class="header">SETTINGS PANEL</li>

            <li class="treeview {{ Request::is('settings') || Request::is('settings/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cogs text-purple"></i>
                    <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('settings') ? 'active' : '' }}">
                        <a href="{{ url('settings') }}">Site Settings</a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>