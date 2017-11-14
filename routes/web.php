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
use App\Contact;

//Route::get('/', function () {
//
//    if (Auth::check()) {
//
//        $contacts = Contact::all();
//        return view('contacts', compact('contacts'));
//
//    }
//    else {
//        return view('auth/login');
//    }
//});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    // Inital page load
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('contact', 'ContactsAjaxController',
        ['only' => [
            'index', 'store','update','destroy'
    ]]);

    Route::apiResource(
        'search', 'ContactsAjaxController',
        ['only' => 'index']
    );


});
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');




