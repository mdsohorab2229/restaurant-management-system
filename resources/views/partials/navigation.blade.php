{{--
    /**
     * Navigation partial, for sidebar menu, injected in master layout
     *
     * @package Restaurant & Hotel Management Software
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

            @if(\Auth::user()->canDo(['manage_admin']))
            <li class="{{ Request::is('pos') || Request::is('pos/') ? 'active' : '' }}">
                <a href="{{ url('pos') }}" target="_blank">
                    <i class="fa fa-desktop text-blue"></i>
                    <span>Point of Sale</span>
                </a>
            </li>
            @endif

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
                    <li class="{{ Request::is('reports/searchstore-kitchen') ? 'active' : '' }}">
                        <a href="{{ url('reports/searchstore-kitchen') }}">Kitchen Store Report</a>
                    </li>
                    <li class="{{ Request::is('reports/cashier') ? 'active' : '' }}">
                        <a href="{{ url('reports/cashier') }}">Cashier Report</a>
                    </li>
                    <li class="{{ Request::is('reports/kitchen') ? 'active' : '' }}">
                        <a href="{{ url('reports/kitchen') }}">Kitchen Report</a>
                    </li>
                    <li class="{{ Request::is('reports/income') ? 'active' : '' }}">
                        <a href="{{ url('reports/income') }}">Income & Expenditure</a>
                    </li>
                    
                </ul>
            </li>

            {{-- manage accounts --}}
            <li class="header">Manage Accounds</li>
            <li class="treeview">
                <a href="{{ url('#') }}">
                    <i class="fa fa-pie-chart text-warning"></i>
                    <span>Accounts</span>
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
                    <li class="{{ Request::is('purchase/lists') ? 'active' : '' }}">
                        <a href="{{ url('purchase/lists') }}">All purchase</a>
                    </li>
                    <li class="{{ Request::is('customer/lists') ? 'active' : '' }}">
                        <a href="{{ url('purchase-category/lists') }}">Purchage Category</a>
                    </li>
                    <li class="{{ Request::is('purchase/lists') ? 'active' : '' }}">
                        <a href="{{ url('purchase/incomestatement') }}">Income Statement</a>
                    </li>
                    <li class="{{ Request::is('ladger/customers-ledger') ? 'active' : '' }}">
                        <a href="{{ url('ladger/customers-ledger') }}">Customer Ladger</a>
                    </li>
                    <li class="{{ Request::is('ladger/supplier-ledger') ? 'active' : '' }}">
                        <a href="{{ url('ladger/supplier-ledger') }}">Suppiler Ladger</a>
                    </li>
                    <li class="{{ Request::is('balancesheets/list') ? 'active' : '' }}">
                        <a href="{{ url('balancesheets/list') }}">Balance Sheet</a>
                    </li>
                </ul>

            </li>

            {{--Manage Product--}}

            <li class="header">Manage Raw Materials</li>
            <li class="treeview">
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
            
            {{-- manage menus & menus categories --}}
            <li class="header">Manage Menus/Dish</li>
            <li class="treeview">
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
            {{-- Kitchen Manage --}}
            <li class="header">Kitchen Manage</li>
            <li class="treeview {{ Request::is('kitchens') || Request::is('kitchens/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cutlery text-danger"></i>
                    <span>Kitchen Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('kitchens') ? 'active' : '' }}">
                        <a href="{{ url('kitchens/list') }}">Kitchen Lists</a>
                    </li>
                    <li class="{{ Request::is('kitchens') ? 'active' : '' }}">
                        <a href="{{ url('kitchens/kitchenandchieflist') }}">Add Chief for Kitchen</a>
                    </li>
                </ul>
            </li>

            {{-- Cash Manage --}}
            <li class="header">Cash Manage</li>
            <li class="treeview {{ Request::is('cashes') || Request::is('cashes/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-cutlery text-danger"></i>
                    <span>Cash Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('cashes') ? 'active' : '' }}">
                        <a href="{{ url('cashes/list') }}">Cash Lists</a>
                    </li>
                    <li class="{{ Request::is('cashes') ? 'active' : '' }}">
                        <a href="{{ url('cashes/cashcashierlist') }}">Add Cashier for Cash</a>
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
                    {{--<li class="{{ Request::is('discountcard/discountlist') ? 'active' : '' }}">--}}
                        {{--<a href="{{ url('discountcard/discountlist') }}">All Discount</a>--}}
                    {{--</li>--}}
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
            {{-- Assets Manage --}}
            <li class="header">Asset Manage</li>
            <li class="treeview {{ Request::is('assets') || Request::is('assets/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-spotify text-danger"></i>
                    <span>Asset Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('assets/list') ? 'active' : '' }}">
                        <a href="{{ url('assets/list') }}">Asset Category</a>
                    </li>
                    <li class="{{ Request::is('assets/assetlist') ? 'active' : '' }}">
                        <a href="{{ url('assets/assetlist') }}">Asset List</a>
                    </li>
                </ul>
            </li>

            {{-- Bank Manage --}}
            <li class="header">Bank Manage</li>
            <li class="treeview {{ Request::is('banks') || Request::is('banks/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-institution text-danger"></i>
                    <span>Bank Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('banks/banklistlist') ? 'active' : '' }}">
                        <a href="{{ url('banks/banklistlist') }}">Bank List</a>
                    </li>
                    {{--<li class="{{ Request::is('banks/bankcategorylist') ? 'active' : '' }}">--}}
                        {{--<a href="{{ url('banks/bankcategorylist') }}">Category</a>--}}
                    {{--</li>--}}
                    <li class="{{ Request::is('banks/list') ? 'active' : '' }}">
                        <a href="{{ url('banks/list') }}">Bank Money</a>
                    </li>
                    <li class="{{ Request::is('banks/loanlist') ? 'active' : '' }}">
                        <a href="{{ url('banks/loanlist') }}">Bank Loan</a>
                    </li>
                </ul>
            </li>

            {{-- Busness Capital Investment --}}
            <li class="header">Investment/Capital Manage</li>
            <li class="treeview {{ Request::is('investments') || Request::is('investments/*') ? 'active' : '' }}">
                <a href="{{ url('#') }}">
                    <i class="fa fa-institution text-danger"></i>
                    <span>Investment/Capital Manage</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('investments/list') ? 'active' : '' }}">
                        <a href="{{ url('investments/list') }}">Investment/Capital</a>
                    </li>

                </ul>
            </li>
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
                    <li class="{{ Request::is('role') || Request::is('role/*') ? 'active' : '' }}">
                        <a href="{{ url('role') }}">Role Manage</a>
                    </li>
                </ul>
            </li>

            @if(true) {{-- check if user has permissions for settings --}}
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
                        <a href="{{ url('settings') }}">Software Settings</a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>