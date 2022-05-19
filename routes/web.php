<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('home', function() {
    return redirect()->route('logout');
});


Route::middleware(['auth'])->group(function (){
    Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index');

    Route::group(['prefix' => 'users'], function (){
        Route::get('/list', 'UsersController@index')->name('users');
        Route::get('/search-list', 'UsersController@searchlist')->name('users.search');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/create', 'UsersController@store')->name('users.store');
        Route::get('/{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('/{id}', 'UsersController@update')->name('users.update');
        Route::delete('/{id}', 'UsersController@destroy')->name('users.destroy');
        Route::get('/{id}/profile', 'UsersController@profile')->name('users.profile');
        Route::post('/changePassword','UsersController@changePassword')->name('users.changePassword');
    });

    Route::prefix('role')->group(function(){
		Route::get('/', 'RoleController@index')->name('role.list');
		Route::post('/create', 'RoleController@store')->name('role.store');
		Route::post('/edit', 'RoleController@edit')->name('role.edit');
		Route::post('/update', 'RoleController@update')->name('role.update');
		Route::delete('delete/{id}', 'RoleController@delete')->name('role.destroy');
		Route::post('/permission', 'RolePermissionController@index')->name('role.permission');
		Route::post('/set-permission', 'RolePermissionController@setPermission')->name('role.permission.set');
	});

    //for procducts    
    Route::group(['prefix' => 'products'], function (){
        Route::get('/list', 'ProductController@index')->name('product.list');
        Route::get('/create', 'ProductController@create')->name('product.create');
        Route::post('/create', 'ProductController@store')->name('product.store');
        Route::get('/request', 'ProductController@requestProduct')->name('product.request');
        Route::get('/canceled-request', 'ProductController@cancelRequestProduct')->name('product.request');
        Route::post('/request/approved/{id}', 'ProductController@requestApproveProduct')->name('product.request.approved');
        Route::post('/request/canceled/{id}', 'ProductController@requestCancelProduct')->name('product.request.canceled');
        Route::get('/{id}/edit', 'ProductController@edit')->name('product.edit');
        Route::post('/{id}/edit', 'ProductController@update')->name('product.update');
        Route::get('/getdata', 'AjaxDataController@getProductData')->name('ajax.get-product');
        Route::get('/getrequestdata', 'AjaxDataController@getRequestProductData')->name('ajax.get-request-product');
        Route::get('/getcanceleddata', 'AjaxDataController@getCanceldProductData')->name('ajax.get-canceled-product');
        Route::delete('/{id}', 'ProductController@destroy')->name('product.destroy');
        Route::post('/kitchen/store', 'ProductController@kitchenStore')->name('product.kitchen.store');
        Route::post('/wasted/store', 'ProductController@wastedStore')->name('product.wasted.store');
        Route::post('/wasted/kitchen-store', 'ProductController@wastedFromKitchen')->name('product.wasted.kitchen-stock');
        Route::post('/stock/store', 'ProductController@backStock')->name('product.stock.store');
        Route::post('/get-quanitity', 'AjaxDataController@getProductQuantity')->name('ajax.get-product.quantity');
        Route::post('/get-kitchen-quantity', 'AjaxDataController@getkitchenQuantity')->name('ajax.get-product.kitchen.quantity');
        Route::get('/kitchen', 'ProductController@kitchenStock')->name('product.kitchen.stock');
        Route::get('/wasted', 'ProductController@wastedStock')->name('product.wasted.stock');
        Route::get('/get-kithcen-stock', 'AjaxDataController@getKitchenStock')->name('ajax.get-kitchen-product');
        Route::get('/get-wasted-stock', 'AjaxDataController@getWastedProduct')->name('ajax.get-wasted-product');
    });

    //for product_category
    Route::group(['prefix' => 'productcategories'], function (){
        Route::get('/list', 'ProductCategoryController@index')->name('product.categories');
        Route::post('/create', 'ProductCategoryController@store')->name('product_category.store');
        Route::post('/edit', 'ProductCategoryController@edit')->name('product_category.edit');
        Route::post('/update', 'ProductCategoryController@update')->name('product_category.update');
        Route::delete('/{id}', 'ProductCategoryController@destroy')->name('product_category.destroy');
        Route::get('/getdata', 'AjaxDataController@getProductCategoryData')->name('ajaxdata.getProductCategoryData');
      
    });

    //for Brand
    Route::group(['prefix' => 'brands'], function (){
        Route::get('/list', 'BrandController@index')->name('brands');
        Route::post('/create', 'BrandController@store')->name('brand.store');
        Route::post('/edit', 'BrandController@edit')->name('brand.edit');
        Route::post('/update', 'BrandController@update')->name('brand.update');
        Route::delete('/{id}', 'BrandController@destroy')->name('brand.destroy');
        Route::get('/getdata', 'AjaxDataController@getBrandData')->name('ajaxdata.getBrandData');
      
    });

    //menu Category
    Route::group(['prefix' => 'menuscategories'], function(){
        Route::get('/lists', 'MenuCategoryController@index')->name('menu.categories');
        Route::post('/create', 'MenuCategoryController@store')->name('menu_category.store');
        Route::post('/edit', 'MenuCategoryController@edit')->name('menu_category.edit');
        Route::post('/update', 'MenuCategoryController@update')->name('menu_category.update');
        Route::delete('/{id}', 'MenuCategoryController@destroy')->name('menu_category.destroy');
        Route::get('/getdata', 'AjaxDataController@getMenuCategory')->name('ajax.menu-category');
    });

    //menu
    Route::group(['prefix' => 'menu'], function(){
        Route::get('/lists', 'MenuController@index')->name('menu');
        Route::post('/create', 'MenuController@store')->name('menu.store');
        Route::post('/view', 'MenuController@view')->name('menu.view');
        Route::post('/test-edit', 'MenuController@tesEdit')->name('menu.edit');
        Route::get('/edit/{id}', 'MenuController@edit')->name('menu.edit');
        Route::post('/edit/{id}', 'MenuController@update')->name('menu.update');
        Route::delete('/{id}', 'MenuController@destroy')->name('menu.destroy');
        Route::get('/getdata', 'AjaxDataController@getMenuData')->name('ajaxdata.getMenuData');
    });

    //menu Category
    Route::group(['prefix' => 'table'], function(){
        Route::get('/', 'TableController@index')->name('table');
        Route::post('/create', 'TableController@store')->name('table.store');
        Route::post('/edit', 'TableController@edit')->name('table.edit');
        Route::post('/update', 'TableController@update')->name('table.update');
        Route::delete('/{id}', 'TableController@destroy')->name('table.destroy');
        Route::get('/getdata', 'AjaxDataController@getTable')->name('ajax.getTableData');
    });

    //Customer Category
    Route::group(['prefix' => 'customer'], function(){
        Route::get('/lists', 'CustomerController@index')->name('customer');
        Route::get('/all-customer', 'CustomerController@getCustomer')->name('get.customers');
        Route::get('/create', 'CustomerController@index')->name('customer.create');
        Route::post('/create', 'CustomerController@store')->name('customer.store');
        Route::post('/edit', 'CustomerController@edit')->name('customer.edit');
        Route::post('/update', 'CustomerController@update')->name('customer.update');
        Route::delete('/{id}', 'CustomerController@destroy')->name('customer.destroy');
        Route::get('/getdata', 'AjaxDataController@getCustomerData')->name('ajaxdata.getCustomerData');
    });

    //for suppliers
    Route::group(['prefix' => 'supplier'], function(){
        Route::get('/lists', 'SupplierController@index')->name('supplier');
        Route::get('/create', 'SupplierController@index')->name('supplier.create');
        Route::post('/create', 'SupplierController@store')->name('supplier.store');
        Route::post('/edit', 'SupplierController@edit')->name('supplier.edit');
        Route::post('/update', 'SupplierController@update')->name('supplier.update');
        Route::delete('/{id}', 'SupplierController@destroy')->name('supplier.destroy');
        Route::get('/getdata', 'AjaxDataController@getSupplierData')->name('ajaxdata.getSupplierData');
    });

    //for Unit category
    Route::group(['prefix' => 'unit'], function(){
        Route::get('/list', 'UnitController@index')->name('units');
        Route::get('/create', 'UnitController@index')->name('units.create');
        Route::post('/create', 'UnitController@store')->name('units.store');
        Route::post('/edit', 'UnitController@edit')->name('units.edit');
        Route::post('/update', 'UnitController@update')->name('units.update');
        Route::delete('/{id}', 'UnitController@destroy')->name('units.destroy');
    });

    //for Expense Category 
    Route::group(['prefix' => 'expense-category'], function(){
        Route::get('/lists', 'ExpenseCategoryController@index')->name('expense-category');
        Route::get('/create', 'ExpenseCategoryController@index')->name('expense-category.create');
        Route::post('/create', 'ExpenseCategoryController@store')->name('expense-category.store');
        Route::post('/edit', 'ExpenseCategoryController@edit')->name('expense-category.edit');
        Route::post('/update', 'ExpenseCategoryController@update')->name('expense-category.update');
        Route::delete('/{id}', 'ExpenseCategoryController@destroy')->name('expense-category.destroy');
        Route::get('/getdata', 'AjaxDataController@getExpenseCategory')->name('ajax.getExpenseCategory');
    });

    //for Purchase Category 
    Route::group(['prefix' => 'purchase-category'], function(){
        Route::get('/lists', 'PurchaseCategoryController@index')->name('purchase-category');
        Route::get('/create', 'PurchaseCategoryController@index')->name('purchase-category.create');
        Route::post('/create', 'PurchaseCategoryController@store')->name('purchase-category.store');
        Route::post('/edit', 'PurchaseCategoryController@edit')->name('purchase-category.edit');
        Route::post('/update', 'PurchaseCategoryController@update')->name('purchase-category.update');
        Route::delete('/{id}', 'PurchaseCategoryController@destroy')->name('purchase-category.destroy');
        Route::get('/getdata', 'AjaxDataController@getPurchaseCategory')->name('ajax.getPurchaseCategory');

    });

    //for expense 
    Route::group(['prefix' => 'expense'], function(){
        Route::get('/lists', 'ExpenseController@index')->name('expense.list');
        Route::get('/create', 'ExpenseController@index')->name('expense.create');
        Route::post('/create', 'ExpenseController@store')->name('expense.store');
        Route::post('/edit', 'ExpenseController@edit')->name('expense.edit');
        Route::post('/update', 'ExpenseController@update')->name('expense.update');
        Route::delete('/{id}', 'ExpenseController@destroy')->name('expense.destroy');
        Route::get('/getdata', 'AjaxDataController@getExpenseData')->name('ajaxdata.getExpenseData');
        Route::get('/reportlists', 'ExpenseController@reportsearch')->name('reportsearch.list');
    });

    //for purchase 
    Route::group(['prefix' => 'purchase'], function(){
        Route::get('/lists', 'PurchaseController@index')->name('purchase.list');
        Route::get('/create', 'PurchaseController@index')->name('purchase.create');
        Route::post('/create', 'PurchaseController@store')->name('purchase.store');
        Route::post('/edit', 'PurchaseController@edit')->name('purchase.edit');
        Route::post('/update', 'PurchaseController@update')->name('purchase.update');
        Route::delete('/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
        Route::get('/getdata', 'AjaxDataController@getPurchaseData')->name('ajaxdata.getPurchaseData');
        Route::get('/report', 'PurchaseController@purchasereport')->name('purchase.report');

        //for income statement
        Route::get('/incomestatement', 'PurchaseController@incomestatement')->name('purchase.incomestatement');
        Route::get('/search-incomestatement', 'PurchaseController@searchIncomestatement')->name('purchase.search-incomestatement');

    });

    //ajax form submit
    Route::post('/add_product_category', 'AjaxSubmitController@productCategory')->name('add-more.category');
    Route::post('/add_brand', 'AjaxSubmitController@brand')->name('add-more.brand');
    Route::post('/add_supplier', 'AjaxSubmitController@supplier')->name('add-more.supplier');
    Route::post('/add_unit', 'AjaxSubmitController@unit')->name('add-more.unit');


    //waiter
    Route::get('/waiter', 'WaiterController@index')->name('waiter.dashboard');

    Route::group(['prefix' => 'waiter'], function(){
        Route::get('/', 'WaiterController@index')->name('waiter.dashboard');
        Route::get('/table', 'WaiterController@table')->name('waiter.table');
        Route::get('/table/{id}', 'WaiterController@tableOrder')->name('table.order');
        Route::post('/menu/find', 'WaiterController@findMenu')->name('find.menu');
        Route::post('/menu/category', 'WaiterController@findCategory')->name('find.menu.category');
        Route::post('/menu-item/search', 'WaiterController@findMenuitem')->name('find.menu-item.search');
        Route::delete('/{id}', 'WaiterController@destroy')->name('order.destroy');
        Route::get('/extra-order/{id}', 'WaiterController@extraOrder')->name('waiter.extra-order');
        Route::get('/load-notification', 'WaiterController@loadNotification')->name('load.waiter-notification');
        Route::post('/order-served', 'WaiterController@orderServed')->name('waiter.order-confirm');
    });
    //for chief
    Route::group(['prefix' => 'chief'], function(){
        Route::get('/', 'ChiefController@index')->name('chief.dashboard');
        Route::get('/load-orders', 'ChiefController@orderLoad')->name('load.orders');
        Route::get('/load-reorders', 'ChiefController@reorderLoad')->name('load.re-orders');
        Route::post('/order-prepared', 'ChiefController@orderPepared')->name('order.prepared');
        Route::get('/token/{id}', 'PrintController@orderToken')->name('chief.token');
        Route::get('/report', 'ChiefController@report')->name('chief.report');
    });

    //Order
    Route::group(['prefix' => 'order'], function(){
        Route::post('/create', 'OrderController@store')->name('order.store');
        Route::get('/token/{id}', 'PrintController@orderToken')->name('order.token');
        Route::get('/reorder-token/{id}', 'PrintController@reOrderToken')->name('reorder.token');
        Route::post('/extra', 'OrderController@extraStore')->name('extra-order.store');
        Route::get('/getdata', 'AjaxDataController@getOrderData')->name('ajaxdata.getOrderData');
        Route::post('/view', 'OrderController@view')->name('order.view');
        Route::post('/menu/view', 'OrderController@menuView')->name('order.menu-view');
        Route::post('/menu/re-order/view', 'OrderController@reorderMenuView')->name('order.menu-re-order-view');
        Route::get('/edit/{id}', 'OrderController@edit')->name('order.edit');
        Route::post('/edit/{id}', 'OrderController@update')->name('order.update');
        Route::get('extra-order/{id}', 'OrderController@extraOrder')->name('order.extra-order');
        Route::post('/extra-cashier', 'OrderController@cashierExtraStore')->name('cashier-extra-order.store');
    });

    //Billing
    Route::group(['prefix' => 'billing'], function(){
        Route::get('/order_list','BillingController@index')->name('order.list');
        Route::get('/billing_list','BillingController@billing_index')->name('billing.list');
        Route::get('/all_billing_list','BillingController@all_billing_index')->name('all_billing.list');
        Route::post('/order_view', 'BillingController@view')->name('order.view');
        Route::post('/create', 'BillingController@create')->name('billing.create');
        Route::post('/make_payment', 'BillingController@make_payment')->name('order.payment');
        Route::delete('/{billing_id}', 'BillingController@destroyBilling')->name('billing.billing.destroy');
        Route::delete('/order/{id}', 'BillingController@destroy')->name('billing.order.destroy');
        Route::get('/getdata_forbilling', 'AjaxDataController@getOrderDataForBilling')->name('ajaxdata.getOrderDataForBilling');
        Route::get('/getdata_billingpage', 'AjaxDataController@getdata_billingpage')->name('ajaxdata.getdata_billingpage');
        Route::get('/getalldata_billingpage', 'AjaxDataController@getalldata_billingpage')->name('ajaxdata.getalldata_billingpage');
        Route::get('/print/{order_id}','PrintController@printView')->name('billing.print_view');
        Route::get('/order-print/{order_id}','PrintController@orderPrintView')->name('order.print_view');
    });

    Route::group(['prefix' => "settings"], function() {
        Route::get('/', 'SettingsController@index')->name('site.settings');
        Route::post('/', 'SettingsController@update')->name('settings.update');
    });

    //reports route
    Route::group(['prefix' => "reports"], function() {
        Route::get('/stock', 'ReportController@stock')->name('report.stock');
        Route::get('/search-stock', 'ReportController@searchstock')->name('report.search-stock');
        Route::get('/get-product', 'AjaxReportController@getProduct')->name('report.get-stock');
        Route::get('/wasted', 'ReportController@wasted')->name('report.stock');
        Route::get('/search-wasted', 'ReportController@searchwasted')->name('report.search-wasted-stock');
        Route::get('/get-wasted-product', 'AjaxReportController@getWastedProduct')->name('report.get-wasted');
        Route::get('/sells', 'ReportController@sell')->name('report.invoice');
        Route::get('/get-invoice', 'AjaxReportController@getInvoice')->name('report.get-invoice');
        Route::get('/profit', 'ReportController@profit')->name('report.profit');
        Route::get('/get-menus', 'AjaxReportController@getMenus')->name('report.get-menus');
        Route::get('/cashier', 'ReportController@cashier')->name('report.cashier');
        Route::get('/get-cashierreport', 'AjaxReportController@getCashierreport')->name('report.get-cashierreport');
        Route::get('/kitchen', 'ReportController@kitchen')->name('report.kitchen');
        Route::get('/searchstore-kitchen', 'ReportController@kitchenstore')->name('report.search-kitchen');
        Route::get('/search-store-kitchen', 'ReportController@searchkitchenstore')->name('report.search-kitchenstore');
        Route::get('/get-kitchenreport', 'AjaxReportController@getKitchenReport')->name('report.get-kitchen-report');
        Route::get('/income', 'ReportController@income')->name('report.income');
        Route::get('/reportincome', 'ReportController@reportincome')->name('report.reportincome');

    });

    //ladger
    Route::group(['prefix' => "ladger"], function() {
        Route::get('/customers-ledger', 'LadgerController@customer')->name('customer-ledger');
        Route::post('/customer-due', 'LadgerController@customerDue')->name('customer-ledger.due');
        Route::get('/customer-due/{id}', 'LadgerController@singleCustomerDue')->name('customer-due');
        Route::post('/customer/due-taken', 'LadgerController@customerDueTaken')->name('due.taken');
        Route::get('/supplier-ledger', 'SupplierController@supplierLedger')->name('supplier.ledger');
        Route::post('/supplier-ledger/store', 'SupplierController@supplierLedgerStore')->name('supplier-ladger.store');
        Route::post('supplier-ledger/edit', 'SupplierController@supplierLedgerEdit')->name('supplier-ladger.edit');
        Route::post('/supplier-ledger/update', 'SupplierController@supplierLedgerUpdate')->name('supplier-ladger.update');
        Route::delete('/supplier-ledger/{id}', 'SupplierController@supplierLedgerDestroy')->name('supplier-ledger.destroy');
        Route::get('/get-menus', 'AjaxDataController@getSupplierLedger')->name('ajaxdata.getSupplierLedgerData');
    });

    // pos
    Route::group(['prefix' => "pos"], function() {
        Route::get('/', 'posController@index')->name('pos');
        Route::post('/billing/create', 'posController@billingStore')->name('pos-order.billing');
        Route::post('/create', 'posController@store')->name('poscreate.store');
    });

    //for Discount Card
    Route::group(['prefix' => 'discountcard'], function (){
        Route::get('/list', 'DiscountCardController@index')->name('discountcard');
        Route::post('/create', 'DiscountCardController@store')->name('discountcard.store');
        Route::post('/edit', 'DiscountCardController@edit')->name('discountcard.edit');
        Route::post('/update', 'DiscountCardController@update')->name('discountcard.update');
        Route::delete('/{id}', 'DiscountCardController@destroy')->name('discountcard.destroy');
        Route::get('/getdata', 'AjaxDataController@getDiscountcardData')->name('ajaxdata.getDiscountcardData');

        //discount member
        Route::get('/discountlist', 'DiscountCardController@discountindex')->name('discountlist');
        Route::post('/discountcreate', 'DiscountCardController@discountstore')->name('discountlist.discountstore');
        Route::post('/discountedit', 'DiscountCardController@discountedit')->name('discountcard.discountedit');
        Route::delete('/{customerdiscount_id}', 'DiscountCardController@discountcustomerdestroy')->name('discountcard.discountcustomerdestroy');
        Route::get('/getdiscountdata', 'AjaxDataController@getDiscountcustomerData')->name('ajaxdata.getDiscountcustomerData');
    });

    //Buffet For Cars
    Route::group(['prefix' => 'buffetcars'], function (){
        Route::get('/list', 'BuffetcarController@index')->name('buffetcars');
        Route::post('/create', 'BuffetcarController@store')->name('buffetcars.store');
        Route::post('/edit', 'BuffetcarController@edit')->name('buffetcars.edit');
        Route::post('/update', 'BuffetcarController@update')->name('buffetcars.update');
        Route::delete('/{id}', 'BuffetcarController@destroy')->name('buffetcars.destroy');
        Route::get('/getdata', 'AjaxDataController@getBuffetcarsData')->name('ajaxdata.getBuffetcarsData');

        Route::get('/buffetcarlist', 'BuffetcarController@indexbuffet')->name('allbuffetcars');
        Route::post('/buffetcaramount', 'BuffetcarController@viewamount')->name('allbuffetcarsamount');
        Route::post('/createbuffetlist', 'BuffetcarController@storebuffetcar')->name('buffetcars.storebuffetcar');
        Route::post('/buffetlistedit', 'BuffetcarController@buffetlistedit')->name('buffetcars.buffetlistedit');
        Route::post('/buffetlistupdate', 'BuffetcarController@buffetlistupdate')->name('buffetcars.buffetlistupdate');
        Route::delete('/{buffet_id}', 'BuffetcarController@buffetdestroy')->name('buffetcars.buffetdestroy');
        Route::get('/buffetcargetdata', 'AjaxDataController@getBuffetData')->name('ajaxdata.getBuffetData');

    });

    //for Kitchen
    Route::group(['prefix' => 'kitchens'], function (){
        Route::get('/list', 'KitchenController@index')->name('kitchen');
        Route::post('/create', 'KitchenController@store')->name('kitchen.store');
        Route::post('/edit', 'KitchenController@edit')->name('kitchen.edit');
        Route::post('/update', 'KitchenController@update')->name('kitchen.update');
        Route::delete('/{id}', 'KitchenController@destroy')->name('kitchen.destroy');
        Route::get('/getdata', 'AjaxDataController@getKitchenData')->name('ajaxdata.getKitchenData');

        //chief add for kitche
        Route::get('/kitchenandchieflist', 'KitchenController@kitchenchiefindex')->name('kitchenchief');
        Route::post('/createchief', 'KitchenController@kitchenchiefstore')->name('kitchenchief.store');
        Route::post('/editchiefandkitchen', 'KitchenController@kitchenchiefedit')->name('kitchenchief.edit');
        Route::post('/updatechief', 'KitchenController@kitchenchiefupdate')->name('kitchenchief.update');
        Route::delete('kitchenchief/{id}', 'KitchenController@kitchenchiefdestroy')->name('kitchenchief.destroy');
        Route::get('/getdataforchief', 'AjaxDataController@getKitchenChiefData')->name('ajaxdata.getKitchenChiefData');

    });
    //for Cash
    Route::group(['prefix' => 'cashes'], function () {
        Route::get('/list', 'CashController@index')->name('cash');
        Route::post('/create', 'CashController@store')->name('cash.store');
        Route::post('/edit', 'CashController@edit')->name('cash.edit');
        Route::post('/update', 'CashController@update')->name('cash.update');
        Route::delete('/{id}', 'CashController@destroy')->name('cash.destroy');
        Route::get('/getdata', 'AjaxDataController@getCashData')->name('ajaxdata.getCashData');


        //cashier add for cash
        Route::get('/cashcashierlist', 'CashController@cashcashierindex')->name('cashcashier');
        Route::post('/createcashcashier', 'CashController@cashcashierstore')->name('cashcashier.store');
        Route::post('/editcashcashier', 'CashController@editcashcashier')->name('cashcashier.edit');
        Route::post('/updatecashcashier', 'CashController@updatecashcashier')->name('cashcashier.update');
        Route::delete('cashcashier/{id}', 'CashController@cashcashierdestroy')->name('cashcashier.destroy');
        Route::get('/getdataforcashcashier', 'AjaxDataController@getCashCashierData')->name('ajaxdata.getCashCashierData');


    });

    //for Asset category and asset
    Route::group(['prefix' => 'assets'], function (){
        Route::get('/list', 'AssetCategoryController@index')->name('asset');
        Route::post('/create', 'AssetCategoryController@store')->name('asset.store');
        Route::post('/edit', 'AssetCategoryController@edit')->name('asset.edit');
        Route::post('/update', 'AssetCategoryController@update')->name('asset.update');
        Route::delete('/{id}', 'AssetCategoryController@destroy')->name('asset.destroy');
        Route::get('/getdata', 'AjaxDataController@getAssetCategoryData')->name('ajaxdata.getAssetCategoryData');

        //asset
        Route::get('/assetlist', 'AssetController@assetindex')->name('assetlist');
        Route::post('/assetcreate', 'AssetController@assetstore')->name('assetlist.store');
        Route::post('/editasset', 'AssetController@assetedit')->name('assetlist.edit');
        Route::post('/updateasset', 'AssetController@assetupdate')->name('assetlist.update');
        Route::delete('asset/{id}', 'AssetController@assetdestroy')->name('assetlist.destroy');
        Route::get('/getdataforasset', 'AjaxDataController@getAssetData')->name('ajaxdata.getAssetData');

    });

    //for bank name category and bank details

    Route::group(['prefix' => 'banks'], function (){
        //bank list
        Route::get('/banklistlist', 'BanklistController@banklistindex')->name('banklist');
        Route::post('/banklistcreate', 'BanklistController@bankliststore')->name('banklist.store');
        Route::post('/banklistedit', 'BanklistController@banklistedit')->name('banklist.edit');
        Route::post('/banklistupdate', 'BanklistController@banklistupdate')->name('banklist.update');
        Route::delete('banklist/{id}', 'BanklistController@banklistdestroy')->name('banklist.destroy');
        Route::get('/getdataforbanklist', 'AjaxDataController@getBanklistData')->name('ajaxdata.getBanklistData');

//        //category
//        Route::get('/bankcategorylist', 'BankCategoryController@index')->name('bankcategory');
//        Route::post('/bankcategorycreate', 'BankCategoryController@store')->name('bankcategory.store');
//        Route::post('/bankcategoryedit', 'BankCategoryController@edit')->name('bankcategory.edit');
//        Route::post('/bankcategoryupdate', 'BankCategoryController@update')->name('bankcategory.update');
//        Route::delete('bankcategory/{id}', 'BankCategoryController@destroy')->name('bankcategory.destroy');
//        Route::get('/getdataforbankcategory', 'AjaxDataController@getBankCategoryData')->name('ajaxdata.getbankcategoryData');

        //bank
        Route::get('/list', 'BankMoneyController@index')->name('bankmoney');
        Route::post('/create', 'BankMoneyController@store')->name('bankmoney.store');
        Route::post('/edit', 'BankMoneyController@edit')->name('bankmoney.edit');
        Route::post('/update', 'BankMoneyController@update')->name('bankmoney.update');
        Route::delete('/{id}', 'BankMoneyController@destroy')->name('bankmoney.destroy');
        Route::get('/getdataforbankmoney', 'AjaxDataController@getBankMoneyData')->name('ajaxdata.BankMoneyData');
        Route::get('/report_bankmoney', 'BankMoneyController@filter')->name('bankmoney.filter');

        //bank loan
        Route::get('/loanlist', 'BankloanController@index')->name('bankloan');
        Route::post('/loancreate', 'BankloanController@store')->name('bankloan.store');
        Route::post('/loanedit', 'BankloanController@edit')->name('bankloan.edit');
        Route::post('/loanupdate', 'BankloanController@update')->name('bankloan.update');
        Route::delete('loan/{id}', 'BankloanController@destroy')->name('bankloan.destroy');
        Route::get('loan/getdataforbankloanmoney', 'AjaxDataController@getBankloanMoneyData')->name('ajaxdata.BankloanMoneyData');
//        Route::get('loan/report_bankloanmoney', 'BankloanController@filterbankloan')->name('bankloan.filter');

    });

    //for Investor/Capital

    Route::group(['prefix' => 'investments'], function (){

        //investment/capital
        Route::get('/list', 'InvestmentController@index')->name('investment');
        Route::post('/create', 'InvestmentController@store')->name('investment.store');
        Route::post('/edit', 'InvestmentController@edit')->name('investment.edit');
        Route::post('/update', 'InvestmentController@update')->name('investment.update');
        Route::delete('/{id}', 'InvestmentController@destroy')->name('investment.destroy');
        Route::get('/getdataforInvestment', 'AjaxDataController@getInvestmentData')->name('ajaxdata.InvestmentData');
//        Route::get('/report_bankmoney', 'InvestmentController@filter')->name('bankmoney.filter');

    });

    //for Balance Sheet

    Route::group(['prefix' => 'balancesheets'], function (){
        Route::get('/list', 'BalanceSheetController@index')->name('balancesheet');
        Route::get('/filter-report', 'BalanceSheetController@filter')->name('balancesheet.filter');

    });

});

// Happy coding dev
