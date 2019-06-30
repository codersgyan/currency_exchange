<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

/**
 * Using Query scope to filter the result by currency
 *
 * @return query
 */

	public function scopeByValute($query, $valute) {
		if ($valute) {
			return $query->orWhere('currency_name', 'LIKE', '%' . $valute . '%')
				->orWhere('currency_code', 'LIKE', '%' . $valute . '%');
		} else {
			return $query;
		}
	}

/**
 * Using Query scope to filter the result by date
 *
 * @return query
 */

	public function scopeByDate($query, $date) {
		if ($date) {
			return $query->whereDate('created_at', $date);
		} else {
			return $query;
		}
	}

/**
 * Using Query scope to filter the result by order
 *
 * @return query
 */

	public function scopeByOrder($query, $order) {
		if ($order) {
			if ($order === 'desc'):
				return $query->orderBy('currency_code', 'desc');
			else:
				return $query->orderBy('currency_code', 'asc');
			endif;
		} else {
			return $query;
		}
	}
}
