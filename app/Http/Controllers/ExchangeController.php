<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Services\FetchCurrency;
use Illuminate\Http\Request;

class ExchangeController extends Controller {

	/**
	 * Get and filter data from the database
	 *
	 * @return View
	 */

	public function index() {

		$currencies = Currency::ByValute(request()->valute)
			->latest()
			->ByDate(request()->date)
			->ByOrder(request()->order)
			->paginate(15);
		return view('exchanges.index', compact('currencies'));
	}

	/**
	 * Show view for date input form with a table
	 *
	 * @return View
	 */

	public function getFetchView() {
		return view('exchanges.fetch');
	}

	/**
	 * Fetch and store data to database manually
	 *
	 * @return View
	 */

	public function fetch(Request $request, FetchCurrency $exchange) {
		//Validate the request
		$request->validate([
			'date' => 'required',
		]);

		//Call apis and get data
		$response = $exchange->call_apis(date('d/m/Y', strtotime($request->date)));

		// If save to db checkbox checked then call save_to_db method from FetchCurrency service class
		// Here we could call Artisan command manually as well
		if ($request->save_to_db):
			$exchange->storeToDb($response);
		endif;

		//Return the json response
		return response()->json(['data' => $response, 'responseCode' => 200]);
	}

	/**
	 * Get the list of currency codes to show in select box.
	 *
	 * @return Collection
	 */

	public function currencyCodes() {
		$currency_codes = Currency::select('currency_code', 'currency_id')
			->distinct('currency_code')
			->get();
		return $currency_codes;
	}

}
