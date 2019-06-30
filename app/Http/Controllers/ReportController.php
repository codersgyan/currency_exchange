<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Services\JsonStore;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller {

	/**
	 * Get the list of the json files stored on the server
	 *
	 * @return Paginated Collection
	 */

	public function index(Request $request) {
		$reports = Storage::disk('public')->files('reports');
		$paginatedItems = $this->paginate($request, array_reverse($reports));
		return view('reports.index', ['items' => $paginatedItems]);
	}

	/**
	 * Custom paginator
	 *
	 * @return Paginated Collection
	 */

	public function paginate($request, $items) {
		// Get current page form url e.x. &page=1
		$currentPage = LengthAwarePaginator::resolveCurrentPage();

		// Create a new Laravel collection from the array data
		$itemCollection = collect($items);

		// Define how many items we want to be visible in each page
		$perPage = 6;

		// Slice the collection to get the items to display in current page
		$currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)
			->all();

		// Create our paginator and pass it to the view
		$paginatedItems = new LengthAwarePaginator($currentPageItems,
			count($itemCollection), $perPage);

		// set url path for generted links
		$paginatedItems->setPath($request->url());
		return $paginatedItems;
	}

	/**
	 * Get the form to fetch records to export as json
	 *
	 * @return View
	 */

	public function create() {
		return view('reports.create');
	}

	/**
	 * Export data to json using some service classes
	 *
	 * @return Json
	 */

	public function toJson(Request $request, JsonStore $json) {

		$from = $request->from_date;
		$to = $request->till_date;

		$currencies = Currency::whereBetween('created_at', [$from, $to])->get();

		// Format the collection to desired format
		$formatedCurrency = [];
		foreach ($currencies as $key => $value) {
			$formatedCurrency[$key]['дата'] = date('d.m.y', strtotime($value->created_at));
			$formatedCurrency[$key]['валюта'] = $value->currency_code;
			$formatedCurrency[$key]['курс'] = $value->value;
		}

		// Calling JsonStore Service class to perform store to json operation
		$json->saveToFile('app/public/reports/',
			json_encode($formatedCurrency, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

		// Give the feedback to the client
		if ($currencies->count()):
			return response()->json(200);
		else:
			return response()->json(100);
		endif;
	}
}
