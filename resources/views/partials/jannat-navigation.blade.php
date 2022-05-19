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
                    <i class="fa fa-dashboard text-danger"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- @if(\Auth::user()->canDo('manage_admin'))
            <li class="{{ Request::is('pos') || Request::is('pos/') ? 'active' : '' }}">
                <a href="{{ url('pos') }}" target="_blank">
                    <i class="fa fa-desktop text-blue"></i>
                    <span>Point of Sale</span>
                </a>
            </li>
            @endif --}}

            {{-- direct sell like pos --}}


            {{-- Customers Manage --}}
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
                        <a href="{{ url('billing/billing_list') }}">Billings</a>
                    </li>
                </ul>
            </li>

            {{-- manage reports --}}
            <li class="header">Manage Reports</li>
            <li class="treeview {{ Request::is('reports') || Request::is('reports/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-pie-chart text-warning"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ url('reports/sells') }}">Sells Rerport</a>
                    </li>
                    <li>
                        <a href="{{ url('reports/profit') }}">Profit Report</a>
                    </li>
                    <li class="{{ Request::is('reports/stock') ? 'active' : '' }}">
                        <a href="{{ url('reports/stock') }}">Stock Report</a>
                    </li>
                    <li class="{{ Request::is('reports/wasted') ? 'active' : '' }}">
                        <a href="{{ url('reports/wasted') }}">Wasted Report</a>
                    </li>
                    
                </ul>
            </li>

            {{--Manage Product--}}

            <li class="header">Manage Products</li>
            <li class="treeview {{ Request::is('products') || Request::is('products/*') || Request::is('productcategories') || Request::is('productcategories/*') || Request::is('brands') || Request::is('brands/*') ||  Request::is('supplier') || Request::is('supplier/*') || Request::is('unit') || Request::is('unit/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cube text-primary"></i>
                    <span>Product</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('products/list') ? 'active' : '' }}">
                        <a href="{{ url('products/list') }}">All Products</a>
                    </li>
                    <li class="{{ Request::is('products/create') ? 'active' : '' }}">
                        <a href="{{ url('products/create') }}">Add Products</a>
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
            
            {{-- manage menus & menus categories --}}
            <li class="header">Manage Menus/Dish</li>
            <li class="treeview {{ Request::is('menu') || Request::is('menu/*') || Request::is('menuscategories') || Request::is('menuscategories/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-viadeo text-success"></i>
                    <span>Menus/Dishes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('menu/lists') ? 'active' : '' }}">
                        <a href="{{ url('menu/lists') }}">All Menus/Dishes</a>
                    </li>
                    <li class="{{ Request::is('menuscategories/lists') ? 'active' : '' }}">
                        <a href="{{ url('menuscategories/lists') }}">Menu Category</a>
                    </li>
                </ul>
            </li>

            <li class="header">Table Manage</li>
            <li class="treeview {{ Request::is('table') || Request::is('table/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-th text-danger"></i>
                    <span>Table Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('table') ? 'active' : '' }}">
                        <a href="{{ url('table') }}">Table Lists</a>
                    </li>
                </ul>
            </li>

            {{-- Customers Manage --}}
            <li class="header">Customer Manage</li>
            <li class="treeview {{ Request::is('customer') || Request::is('customer/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-male text-custom"></i>
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

            {{-- Customers Manage --}}
            <li class="header">Laser Manage</li>
            <li class="treeview {{ Request::is('ladger') || Request::is('ladger/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-male text-custom"></i>
                    <span>ledger</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('ladger/customers-ledger') ? 'active' : '' }}">
                        <a href="{{ url('ladger/customers-ledger') }}">Customer Ladger</a>
                    </li>
                    <li class="{{ Request::is('ladger/supplier-ledger') ? 'active' : '' }}">
                        <a href="{{ url('ladger/supplier-ledger') }}">Suppiler Ladger</a>
                    </li>
                </ul>
            </li>

            {{-- Customers Manage --}}
            <li class="header">Expenses Manage</li>
            <li class="treeview {{ Request::is('expense-category') || Request::is('expense-category/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-line-chart text-primary"></i>
                    <span>Expenses</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('expense/lists') ? 'active' : '' }}">
                        <a href="{{ url('expense/lists') }}">All Expense</a>
                    </li>
                    <li class="{{ Request::is('expense-category/lists') ? 'active' : '' }}">
                        <a href="{{ url('expense-category/lists') }}">Expense Category</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="treeview {{ Request::is('expense-category') || Request::is('expense-category/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-glass text-primary"></i>
                    <span>Purchases</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('customer/lists') ? 'active' : '' }}">
                        <a href="{{ url('expense-category/lists') }}">All purchase</a>
                    </li>
                    <li class="{{ Request::is('customer/lists') ? 'active' : '' }}">
                        <a href="{{ url('expense-category/lists') }}">Purchage Category</a>
                    </li>
                </ul>
            </li> --}}

            {{--Discount Card--}}
            <li class="header">Manage Discount Card</li>
            <li class="treeview {{ Request::is('discountcard') || Request::is('discountcard/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-tags text-danger"></i>
                    <span>Discount Card</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('discountcard/list') ? 'active' : '' }}">
                        <a href="{{ url('discountcard/list') }}">All Card</a>
                    </li>
                    <li class="{{ Request::is('discountcard/discountlist') ? 'active' : '' }}">
                        <a href="{{ url('discountcard/discountlist') }}">All Discount</a>
                    </li>
                </ul>
            </li>

            {{--Buffet For Bussess--}}
            <li class="header">Buffet For Bussess</li>
            <li class="treeview {{ Request::is('buffetcars') || Request::is('buffetcars/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-car text-danger"></i>
                    <span>Buffet For Busses</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('buffetcars/list') ? 'active' : '' }}">
                        <a href="{{ url('buffetcars/list') }}">All Car</a>
                    </li>
                    <li class="{{ Request::is('buffetcars/buffetcarlist') ? 'active' : '' }}">
                        <a href="{{ url('buffetcars/buffetcarlist') }}">All Buffet</a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>