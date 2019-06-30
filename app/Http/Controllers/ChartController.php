<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\JsonStore;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ChartController extends Controller {

	/**
	 * Showing chart view
	 *
	 * @return View
	 */

	public function show() {
		return view('exchanges.chart');
	}

	/**
	 * Get the analytics data ( changes in currency values in certail period)
	 *
	 * @return Collection
	 */

	public function analytics(Request $request, ApiService $api_service, JsonStore $json) {

		$from_date = date('d/m/Y', strtotime($request->from_date));
		$till_date = date('d/m/Y', strtotime($request->till_date));
		$currency_id = $request->currency_id;

		// Load by default when page loads
		if (!$request->currency_id):
			$from_date = '01/03/2019';
			$till_date = date('d/m/Y', strtotime(Carbon::now()));
			$currency_id = 'R01235';
		endif;

		// calling ApiService class to call apis
		$analytics = $api_service->get_analytics(
			$from_date,
			$till_date,
			$currency_id
		);

		// Store json To the file using JsonStore service class which is injected in this method
		if ($request->storeAsJson):
			$newJsonString = json_encode($analytics, JSON_PRETTY_PRINT);
			$json->saveToFile('app/public/reports/', $newJsonString);
		endif;

		// Calling custom mapCollection method to map the collection in proper format
		return $this->mapCollection(collect($analytics->Record));
	}

	/**
	 * Map the given collection to desired format
	 *
	 * @return Modified Collection
	 */

	public function mapCollection($collection) {
		Collection::macro('toAssoc', function () {
			return $this->reduce(function ($assoc, $keyValuePair) {
				list($key, $value) = $keyValuePair;
				$assoc[$key] = $value;
				return $assoc;
			}, new static );
		});

		Collection::macro('mapToAssoc', function ($callback) {
			return $this->map($callback)->toAssoc();
		});

		return $collection->mapToAssoc(function ($currency) {
			return [$currency->{'@attributes'}->Date, str_replace(",", ".", $currency->Value)];
		});

	}
}
