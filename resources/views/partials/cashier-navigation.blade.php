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
            <li class="{{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            //for pos system sell
            <li class="{{ Request::is('pos') || Request::is('pos/') ? 'active' : '' }}">
                <a href="{{ url('pos') }}" target="_blank">
                    <i class="fa fa-desktop text-blue"></i>
                    <span>Point of Sale</span>
                </a>
            </li>

            {{-- Customers Manage --}}
            <li class="header">Customer Manage</li>
            <li class="treeview {{ Request::is('customer') || Request::is('customer/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cube"></i>
                    <span>Customers</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('customer/lists') ? 'active' : '' }}">
                        <a href="{{ url('customer/lists') }}">All Customers</a>
                    </li>
                </ul>
            </li>


            {{-- Billing Manage --}}
            <li class="header">Manage Orders & Billing</li>
            <li class="treeview {{ Request::is('billing') || Request::is('billing/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-trello text-warning"></i>
                    <span>Orders & Billing</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('billing/order_list') ? 'active' : '' }}">
                        <a href="{{ url('billing/order_list') }}">Orders</a>
                    </li>
                    <li class="{{ Request::is('billing/billing_list') ? 'active' : '' }}">
                        <a href="{{ url('billing/billing_list') }}">Today Billings</a>
                    </li>
                    <li class="{{ Request::is('billing/all_billing_list') ? 'active' : '' }}">
                        <a href="{{ url('billing/all_billing_list') }}">All Billings</a>
                    </li>
                    <li class="{{ Request::is('reports/cashier') ? 'active' : '' }}">
                        <a href="{{ url('reports/cashier') }}">Cashier Report</a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>