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
//Home page
Route::get('/', function () {
	return view('welcome');
});

// Table view for the currencies and value with sorting and filters
Route::get('exchange-rates', 'ExchangeController@index')->name('exchanges.index');

// Chart view for given period and currency
Route::get('exchange-rates/graphs', 'ChartController@show')->name('exchanges.chart.show');

// View for fetch currencies from the api for given date and ability to store it to db
Route::get('exchange-rates/fetch', 'ExchangeController@getFetchView')->name('exchanges.getFetchView');

// Post the fetch currency form
Route::post('exchange-rates/fetch', 'ExchangeController@fetch')->name('exchanges.fetch');

// Get all currency codes to show in a select box
Route::get('exchanges/currency-codes', 'ExchangeController@currencyCodes');

// Endpoint to get changes in rates from api for given date range
Route::post('exchanges/analytics', 'ChartController@analytics');

//Get the list of the all saved json files and ability to download
Route::get('reports', 'ReportController@index')->name('reports.index');

// Get View to show export to json form with date range inputs
Route::get('reports/export-to-json', 'ReportController@create')->name('valute.export.create');

// Post the export to json form to export given data to the json
Route::post('reports/export-to-json', 'ReportController@toJson')->name('valute.export.tojson');

// Authentication routes
Auth::routes();

// Home page after loged in
Route::get('/home', 'HomeController@index')->name('home');
