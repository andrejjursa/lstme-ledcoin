<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function operations_ledcoin_limit_check($quantity, $date = NULL) {
	$daily_limit = operations_ledcoin_daily_limit($date);
	//echo 'LIMIT: ' . $daily_limit;
	//echo 'QUANTITY: ' . $quantity;

	if ($daily_limit > 0) {
		$used_amount = operations_ledcoin_added_in_day($date);
		//echo 'USED: ' . $used_amount;

		if ($quantity <= ($daily_limit - $used_amount)) {
			return TRUE;
		}
	}

	return FALSE;
}

function operations_ledcoin_daily_limit($date = NULL) {
	if ($date === NULL) {
		$date = date('Y-m-d');
	} else {
		if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $date)) {
			return 0.0;
		}

		list($year, $month, $day) = explode('-', $date);

		if (!checkdate($month, $day, $year)) {
			return 0.0;
		}
	}

	$limit = new Limits();
	$limit->get_where(array('date' => $date));

	if ($limit->exists()) {
		return (double)$limit->daily_limit;
	}
	return 0.0;
}

function operations_ledcoin_added_in_day($date = NULL) {
	if ($date === NULL) {
		$date = date('Y-m-d');
	} else {
		if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $date)) {
			return 0.0;
		}

		list($year, $month, $day) = explode('-', $date);

		if (!checkdate($month, $day, $year)) {
			return 0.0;
		}
	}

	$date_from = $date . ' 00:00:00';
	$date_to = $date . ' 23:59:59';

	$operations_addition = new Operation();
	$operations_addition->where('type', Operation::TYPE_ADDITION);
	$operations_addition->select_sum('amount', 'amount_sum');
	$operations_addition->where('created >=', $date_from);
	$operations_addition->where('created <=', $date_to);
	$operations_addition->get();

	return (double)$operations_addition->amount_sum;
}