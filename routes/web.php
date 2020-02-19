<?php





Route::group(['namespace'=>'Website','as'=>'website.'],function(){
        
        
        Route::post('/auth','WebsiteController@login')->name('login');
        Route::get('/signout','WebsiteController@signout');

        Route::get('/checkAuth','WebsiteController@checkLogin');
        

        Route::group(['prefix'=>'/webapi','as'=> 'webapi'],function(){
                Route::resource('/user','UserController');
                Route::resource('/roles','RolesController')->except(['create','delete']);
                Route::resource('/expense-categories','ExpenseCategoryController')->except(['create']);
                Route::resource('/expenses','ExpenseController')->except(['create']);
                Route::get('/chart','ExpenseCategoryController@chart');
               Route::post('/save-profile','UserController@saveProfile');

        });
        Route::get('/{any}','WebsiteController@index')->where('any','.*');


});




