<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */


    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

    Route::get('/', 'HomeController@index')->name('home.index');

    Route::get('/pdf', 'PdfController@index')->name('home.index');


   

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'AuthController@show')->name('auth.show');
        Route::post('/login', 'AuthController@login')->name('auth.perform');


        /**
         * Remind password Routes
         */
        Route::get('/remindpassword', 'AuthController@remindpassword')->name('auth.remind_password');
        Route::post('/remindpassword', 'AuthController@remindpassword')->name('auth.remind_password');


    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        Route::get('/profile', 'UsersController@index')->name('users.index');


        Route::get('/logout', 'AuthController@logout')->name('auth.logout');


        Route::get('/profile/details', 'UsersController@show_one_user_by_user')->name('auth.showoneuser');
        Route::get('/profile/edit_by_user', 'UsersController@editProfileByUser')->name('auth.ChangUserByUser');

        Route::post('/profile/edit_by_user', 'UsersController@editProfileByUserPost')->name('auth.ChangUserByAdmin');

        Route::get('/profile/delete/{id}', 'UsersController@deleteuser')->name('auth.deleteuser');

        Route::get('/profile/change_password_by_user', 'UsersController@changePasswordByUser')->name('auth.changepasswordbyuser');
        Route::post('/profile/change_password_by_user', 'UsersController@changePasswordByUserPost')->name('auth.changepasswordbyuser');

        Route::get('/blowings/list', 'BlowingsController@showBlowingsByUser')->name('blowings.blowingsList');


        Route::get('/blowings/list/{user_id}', 'BlowingsController@showBlowingsByAdmin')->name('blowings.blowingList'); // niedokończone

        Route::get('/blowing/show/{id}', 'BlowingsController@showBlowingByUser')->name('blowings.showBlowing');
        Route::get('/blowing/edit/{id}', 'BlowingsController@editBlowingByUser')->name('blowings.editBlowing');
        Route::get('/blowing/show_source/{id}', 'BlowingsController@ShowBlowingSource')->name('blowings.showBlowingSource');

        #Route::post('/blowing/edit/', 'BlowingsController@editBlowingByUserPost')->name('blowings.editBlowing');
        Route::get('/blowing/make_pdf/{id}', 'BlowingsController@MakePdfBlowingByUser')->name('blowings.makePdfBlowing');
        Route::get('/pdf/show_chart/{id}', 'PdfController@showChart')->name('pdf.deleteMyOwnAccountConfirmation');


        


        Route::post('/blowing/delete_many', 'BlowingsController@DeleteManyBlowingsConfirm')->name('blowings.deleteManyBlowingsConfirm');
        
        //Route::post('/blowing/delete', 'BlowingsController@DeleteBlowingPost');

        //Route::post('/blowing/delete_many_confirmed', 'BlowingsController@DeleteManyBlowingsConfirmed')->name('blowings.deleteManyBlowings');


        //Route::get('/blowing/binary_test', 'BlowingsController@DecodeBinaryTableFile')->name('blowings.decodeBinaryTableFile');

        //Route::get('/admin/blowing/edit/{user_id}/{blowing_id}', 'BlowingsController@editBlowingByAdmin')->name('blowings.editBlowing');

        // Route::get('/profile/change-password', [ChangePasswordController::class, 'index']);
        // Route::post('/profile/change-password', [ChangePasswordController::class, 'changePassword'])->name('change.password'); 

        Route::get('/blowings/add', 'BlowingsController@uploadForm');
        Route::post('/blowings/add_step1', 'BlowingsController@uploadSubmit1')->name('blowings.uploadSubmit1');
        


        Route::get('/blowings/add_step1', 'BlowingsController@uploadForm');
        

        Route::post('/blowings/add_step2', 'BlowingsController@uploadSubmit2')->name('blowings.uploadSubmit2');



        Route::get('/clients/list', 'ClientsController@index')->name('clients.clientsList');
        Route::post('/clients/delete_many', 'ClientsController@DeleteManyClientsConfirm')->name('clients.deleteManyClientsConfirm');
        Route::post('/client/delete', 'ClientsController@DeleteClientsPost');
        
        Route::get('/clients/add', 'ClientsController@addClient')->name('clients.editClient');
        Route::post('/clients/add', 'ClientsController@addClientPost')->name('clients.editClient');

        Route::get('/clients/edit/{id}', 'ClientsController@editClient')->name('clients.editClient');
        Route::post('/clients/edit', 'ClientsController@editClientPost')->name('clients.editClient');

        //deleteManyClientsConfirm

        //Route::get('/blowing/delete/{id}', 'BlowingsController@DeleteBlowing')->name('blowings.deleteBlowing');
        Route::post('/blowing/delete', 'BlowingsController@DeleteBlowingPost');



        
        Route::get('/profile/confirm_delete_account', 'UsersController@deleteMyOwnAccountConfirmation')->name('auth.deleteMyOwnAccountConfirmation');

        Route::post('/profile/confirm_delete_account', 'UsersController@deletePermanentlyMyOwnAccount')->name('auth.deletePermanentlyMyOwnAccount');



    });


    Route::group(['middleware' => ['admin']], function() {

        Route::get('/profiles', 'UsersController@profiles')->name('users.index');

        Route::get('/profile/change_password_by_admin/{id}', 'UsersController@changePasswordByAdmin')->name('auth.changepasswordbyadmin')->where('id', '[0-9]+');
        Route::post('/profile/change_password_by_admin', 'UsersController@changePasswordByAdminPost')->name('auth.changepasswordbyadmin');
        Route::get('/profile/details/{id}', 'UsersController@show_one_user_by_admin')->name('auth.showoneuser');

        Route::get('/profile/edit_profile_by_admin/{id}', 'UsersController@editProfileByAdmin')->name('auth.edituserbyadmin');
        Route::post('/profile/edit_profile_by_admin', 'UsersController@editProfileByAdminPost')->name('auth.ChangUserByAdmin');
    });
});
