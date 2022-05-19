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
            {{-- manage raw materials --}}
            <li class="header">Manage Raw Materials</li>
            <li class="treeview {{ Request::is('products') || Request::is('products/*') || Request::is('productcategories') || Request::is('productcategories/*') || Request::is('brands') || Request::is('brands/*') ||  Request::is('supplier') || Request::is('supplier/*') || Request::is('unit') || Request::is('unit/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cube text-primary"></i>
                    <span>Raw Materials</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('products/list') ? 'active' : '' }}">
                        <a href="{{ url('products/list') }}">All Raw Materials</a>
                    </li>
                    <li class="{{ Request::is('products/request') ? 'active' : '' }}">
                        <a href="{{ url('products/request') }}">Request Raw Materials</a>
                    </li>
                    <li class="{{ Request::is('products/canceled-request') ? 'active' : '' }}">
                        <a href="{{ url('products/canceled-request') }}">Canceled Request</a>
                    </li>
                    <li class="{{ Request::is('products/create') ? 'active' : '' }}">
                        <a href="{{ url('products/create') }}">Add Raw Material</a>
                    </li>
                    <li class="{{ Request::is('productcategories/list') ? 'active' : '' }}">
                        <a href="{{ url('productcategories/list') }}">Categories</a>
                    </li>
                    <li class="{{ Request::is('brands/list') ? 'active' : '' }}">
                        <a href="{{ url('brands/list') }}">Brands</a>
                    </li>
                    <li class="{{ Request::is('supplier/lists') ? 'active' : '' }}">
                        <a href="{{ url('supplier/lists') }}">Suppliers</a>
                    </li>
                    <li class="{{ Request::is('unit/list') ? 'active' : '' }}">
                        <a href="{{ url('unit/list') }}">Units</a>
                    </li>
                </ul>
            </li>



        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>