<?php
Route::middleware(['auth'])->group(function (){
    Route::get('/hotel-dashboard','Hotel\DashboardController@index')->name('hotel.dashboard');

    Route::group(['prefix' => 'hotel'], function (){
        Route::post('/payment', 'Hotel\PaymentController@paymentStore')->name('hotel.guest.payment');
        Route::post('/guest/payment', 'Hotel\PaymentController@findGuestPayment')->name('hotel.guest.payment.find');
        Route::delete('/{id}', 'Hotel\PaymentController@destroy')->name('guestPayment.destroy');
    });

    //for guest
    Route::group(['prefix' => 'guest'], function (){
        Route::get('/list', 'Hotel\GuestController@index')->name('guest');
        Route::post('/create', 'Hotel\GuestController@store')->name('guest.store');
        Route::delete('/{id}', 'Hotel\GuestController@destroy')->name('guest.destroy');
        Route::post('/edit', 'Hotel\GuestController@edit')->name('guest.edit');
        Route::post('/update', 'Hotel\GuestController@update')->name('guest.update');
        Route::get('/getdata', 'Hotel\AjaxDataController@getGuestData')->name('ajaxdata.getguestData');
    });

    //for Room Category
    Route::group(['prefix' => 'roomcategory'], function (){
        Route::get('/list', 'Hotel\RoomCategoryController@index')->name('roomcategory');
        Route::post('/create', 'Hotel\RoomCategoryController@store')->name('roomcategory.store');
        Route::delete('/{id}', 'Hotel\RoomCategoryController@destroy')->name('roomcategory.destroy');
        Route::post('/edit', 'Hotel\RoomCategoryController@edit')->name('roomcategory.edit');
        Route::post('/update', 'Hotel\RoomCategoryController@update')->name('roomcategory.update');
        Route::get('/getdata', 'Hotel\AjaxDataController@getroomcategoryData')->name('ajaxdata.getroomcategoryData');
    });

    
     //for Room 
     Route::group(['prefix' => 'room'], function (){
        Route::get('/list', 'Hotel\RoomController@index')->name('room');
        Route::post('/create', 'Hotel\RoomController@store')->name('room.store');
        Route::delete('/{id}', 'Hotel\RoomController@destroy')->name('room.destroy');
        Route::post('/edit', 'Hotel\RoomController@edit')->name('room.edit');
        Route::post('/update', 'Hotel\RoomController@update')->name('room.update');
        Route::get('/getdata', 'Hotel\AjaxDataController@getroomData')->name('ajaxdata.getroomData');
    });

    //for Room Booking 
    Route::group(['prefix' => 'roombooking'], function (){
        Route::get('/list', 'Hotel\RoomBookingController@index')->name('roombooking');
        Route::post('/create', 'Hotel\RoomBookingController@store')->name('roombooking.store');
        Route::get('/edit/{id}', 'Hotel\RoomBookingController@edit')->name('roombooking.edit');
        Route::post('/edit/{id}', 'Hotel\RoomBookingController@update')->name('roombooking.update');
        Route::delete('/{id}', 'Hotel\RoomBookingController@destroy')->name('roombooking.destroy');
    });

    //for Room Booking 
    Route::group(['prefix' => 'reports'], function (){
        Route::get('/list', 'Hotel\ReportController@index')->name('report.list');
        Route::get('/payment', 'Hotel\ReportController@paymentReport')->name('report.payment');
        Route::get('/guest', 'Hotel\ReportController@guestReport')->name('report.guest');
        Route::get('/payment-filter', 'Hotel\ReportController@filterPayment')->name('report.search-payment');
        Route::get('/getdata', 'Hotel\AjaxDataController@getGuestPaymentData')->name('ajaxdata.getGuestPaymentData');
    });
});