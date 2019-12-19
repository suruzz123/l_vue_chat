<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('userlist', 'MessageController@user_list')->name('user.list');
Route::get('usermessage/{id}', 'MessageController@user_message')->name('user.message');
Route::post('sendmessage', 'MessageController@send_message')->name('user.message.send');
Route::get('deletesinglemessage/{id}', 'MessageController@delete_single_message')->name('user.message.delete');
Route::get('deletetotalmessage/{id}', 'MessageController@delete_total_message')->name('user.message.delete.total');




