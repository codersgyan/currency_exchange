<?php
namespace App\Services;

use GuzzleHttp\Client;

/**
 * Get the analytics from the api using guzzle http client for given date range and currency
 *
 * @return Json decoded array
 */

class ApiService {
	public function get_analytics($from_date, $till_date, $currency_code) {

		$client = new \GuzzleHttp\Client();
		$response = $client->get("http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=" . $from_date . "&date_req2=" . $till_date . "&VAL_NM_RQ=" . $currency_code);

		$xml = simplexml_load_string((string) $response->getBody());
		$json = json_encode($xml);

		return json_decode($json);
	}
}