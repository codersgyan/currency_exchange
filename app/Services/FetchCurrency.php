<?php
namespace App\Services;

use App\Currency;

class FetchCurrency {
	/**
	 * Fetch method to call apis and store to db
	 *
	 * @return Boolean
	 */
	public function fetch($date) {
		$response = $this->call_apis($date);
		$this->storeToDb($response);
		return true;
	}

	/**
	 * Call apis using http client and return the response
	 *
	 * @return Json decoded Object
	 */

	public function call_apis($date) {
		$client = new \GuzzleHttp\Client();
		$response = $client->get("http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date");
		$xml = simplexml_load_string((string) $response->getBody());
		$json = json_encode($xml);
		return json_decode($json);
	}

	/**
	 * Store fetched data to the Database
	 *
	 * @return Boolean
	 */

	public function storeToDb($data) {
		$deleteIfExist = Currency::whereDate('created_at', \Carbon\Carbon::createFromFormat('d.m.Y',
			$data->{'@attributes'}->Date)
				->toDateString())->delete();

		foreach ($data->Valute as $valute) {
			$currency = new Currency;
			$currency->currency_id = $valute->{'@attributes'}->ID;
			$currency->currency_code = $valute->CharCode;
			$currency->currency_name = $valute->Name;
			$currency->nominal = $valute->Nominal;
			$currency->value = str_replace(",", ".", $valute->Value);
			$currency->created_at = \Carbon\Carbon::createFromFormat('d.m.Y', $data->{'@attributes'}->Date)
				->timestamp;
			$currency->save();
		}
		return true;
	}

}