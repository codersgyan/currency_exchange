<?php
namespace App\Services;
use Carbon\Carbon;
use File;

/**
 * Save given data to the json file
 *
 * @return Void
 */

class JsonStore {
	public function saveToFile($path = 'app/public/reports/', $json) {
		$fileName = Carbon::now() . '_report.json';
		File::put(storage_path($path . $fileName), stripslashes($json));
	}
}