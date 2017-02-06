<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('about', 'HomeController@about');
Route::get('help', 'HomeController@help');
Route::get('downloads', 'HomeController@downloads');

// Generic Devices
Route::group(array('prefix' => 'device'), function()
{
	Route::get('/', 'HomeController@index');
	Route::get('home', 'HomeController@index');

	Route::group(array('prefix' => 'generic'), function()
	{
		Route::get('/', 'GenericDeviceController@index');
		Route::get('home', 'GenericDeviceController@index');
		Route::get('config/{id}', 'GenericDeviceController@config');
	});

	// Kinect Devices
	Route::group(array('prefix' => 'kinect'), function()
	{
		Route::post('/', 'KinectDeviceController@index');
		Route::post('home', 'KinectDeviceController@index');
		Route::get('/', 'KinectDeviceController@index');
		Route::get('home', 'KinectDeviceController@index');
		Route::get('config/{id}', 'KinectDeviceController@config');
	});
});

// Administration
Route::group(array('prefix' => 'admin'), function()
{
	Route::get('/', 'AdminController@index');
	Route::get('home', 'AdminController@index');

	// Kinect Administration
	Route::group(array('prefix' => 'kinect'), function()
	{
		Route::get('/', 'AdminController@index');
		Route::get('home', 'AdminController@index');
		Route::get('devices', 'KinectController@devices');
		Route::get('configs', 'KinectController@configs');
		Route::post('configs/add', 'KinectController@addConfig');
		Route::post('configs/addApp', 'KinectController@addConfigApp');
		Route::post('configs/removeApp', 'KinectController@removeConfigApp');
		Route::get('configs/{id}/apps', 'KinectController@configApps');
		Route::get('themes', 'KinectController@themes');
		Route::post('themes/add', 'KinectController@addTheme');
		Route::get('apps', 'KinectController@apps');
		Route::post('apps/add', 'KinectController@addApp');
		Route::get('schedulers', 'KinectController@schedulers');
	});

	// Generic Administration
	Route::group(array('prefix' => 'generic'), function()
	{
		Route::get('/', 'AdminController@index');
		Route::get('home', 'AdminController@index');
		Route::get('devices', 'GenericController@devices');
		Route::get('configs', 'GenericController@configs');
		Route::post('configs/add', 'GenericController@addConfig');
		Route::post('configs/addItem', 'GenericController@addConfigItem');
		Route::post('configs/removeItem', 'GenericController@removeConfigItem');
		Route::post('configs/increaseItem', 'GenericController@increaseConfigItemPriority');
		Route::post('configs/decreaseItem', 'GenericController@decreaseConfigItemPriority');
		Route::get('configs/{id}/items', 'GenericController@configItems');
		Route::get('templates', 'GenericController@templates');
		Route::post('templates/add', 'GenericController@addTemplate');
		Route::get('items', 'GenericController@items');
		Route::post('items/add', 'GenericController@addItem');
		Route::get('schedulers', 'GenericController@schedulers');
	});
});


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
