<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	/**
	 * Tests if LEDCOIN quantity exceed daily limit.
	 *
	 * @param double      $quantity quantity to check.
	 * @param null|string $date     date to check, leave null for current day.
	 *
	 * @return bool
	 */
	function operations_ledcoin_limit_check($quantity, $date = NULL) {
		$daily_limit = operations_ledcoin_daily_limit($date);

		if ($daily_limit > 0) {
			$used_amount = operations_ledcoin_added_in_day($date);

			if ($quantity <= ($daily_limit - $used_amount)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Get limit from database for specified date.
	 *
	 * @param null|string $date date from which limit will be obtained, leave null for current day.
	 *
	 * @return double daily limit.
	 */
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

		$limit = new Limit();
		$limit->get_where(array('date' => $date));

		if ($limit->exists()) {
			return (double)$limit->daily_limit;
		}

		return 0.0;
	}

	/**
	 * Get amount of added LEDCOIN in specified date.
	 *
	 * @param null|string $date           date from which amount of added LEDCOIN will be obtained, leave null for
	 *                                    current day or ALL for all days.
	 * @param string      $operation_type type of addition operation.
	 *
	 * @return double LEDCOIN added in day.
	 */
	function operations_ledcoin_added_in_day($date = NULL, $operation_type = Operation::ADDITION_TYPE_TRANSFER) {
		if ($date === NULL) {
			$date = date('Y-m-d');

			$date_from = $date . ' 00:00:00';
			$date_to   = $date . ' 23:59:59';
		} elseif ($date == 'ALL') {
			$date = date('Y-m-d');

			$date_from = '1970-01-01 00:00:00';
			$date_to   = $date . ' 23:59:59';
		} else {
			if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $date)) {
				return 0.0;
			}

			list($year, $month, $day) = explode('-', $date);

			if (!checkdate($month, $day, $year)) {
				return 0.0;
			}

			$date_from = $date . ' 00:00:00';
			$date_to   = $date . ' 23:59:59';
		}


		$operations_addition = new Operation();
		$operations_addition->where('type', Operation::TYPE_ADDITION);
		$operations_addition->select_sum('amount', 'amount_sum');
		$operations_addition->where('created >=', $date_from);
		$operations_addition->where('created <=', $date_to);
		$operations_addition->where('addition_type', $operation_type);
		$operations_addition->get();

		return (double)$operations_addition->amount_sum;
	}

	/**
	 * Get LEDCOIN multiplier for specified date.
	 * Will use constants ledcoin_multiplier_min and ledcoin_multiplier_max from application config file.
	 *
	 * @param null|string $date date from which multiplier will be obtained, leave null for current day.
	 *
	 * @return double value of multiplier.
	 */
	function operations_ledcoin_multiplier() {
		$added = operations_ledcoin_added_in_day('ALL', Operation::ADDITION_TYPE_MINING);

		$CI =& get_instance();
		$CI->config->load('application');
		$min   = (double)$CI->config->item('ledcoin_multiplier_min');
		$max   = (double)$CI->config->item('ledcoin_multiplier_max');
		$total = (double)$CI->config->item('ledcoin_maximum');

		if ($total == 0) {
			$total = 0.0001;
		}

		$multiplier = ($added + $total) / $total;

		if ($multiplier < $min) {
			$multiplier = $min;
		} elseif ($multiplier > $max) {
			$multiplier = $max;
		}

		$multiplier *= 1000;
		$multiplier = (double)((double)round($multiplier) / 1000.0);

		return $multiplier;
	}

	/**
	 * Return all LEDCOIN transfered to attendants account.
	 * @return double LEDCOIN sum.
	 */
	function operations_ledcoin_transfered() {
		return operations_ledcoin_added_in_day('ALL', Operation::ADDITION_TYPE_TRANSFER);
	}

	/**
	 * Return all LEDCOIN mined by attendants.
	 * @return double LEDCOIN sum.
	 */
	function operations_ledcoin_mined() {
		return operations_ledcoin_added_in_day('ALL', Operation::ADDITION_TYPE_MINING);
	}

	/**
	 * Return all LEDCOIN returned from attendants account.
	 * @return double LEDCOIN sum.
	 */
	function operations_ledcoin_used() {
		$operations_subtraction_direct = new Operation();
		$operations_subtraction_direct->where('type', Operation::TYPE_SUBTRACTION);
		$operations_subtraction_direct->where('subtraction_type', Operation::SUBTRACTION_TYPE_DIRECT);
		$operations_subtraction_direct->select_sum('amount', 'amount_sum');

		$operations_subtraction_products = new Operation();
		$operations_subtraction_products->where('type', Operation::TYPE_SUBTRACTION);
		$operations_subtraction_products->where('subtraction_type', Operation::SUBTRACTION_TYPE_PRODUCTS);
		$operations_subtraction_products->where_related('product_quantity', 'price >', 0);
		$operations_subtraction_products->group_start(' NOT', 'AND');
		$operations_subtraction_products->where_related('product_quantity', 'product_id', NULL);
		$operations_subtraction_products->group_end();
		unset($operations_subtraction_products->db->ar_select[0]);
		$operations_subtraction_products->select_func('SUM', array(
			'@product_quantities.quantity',
			'*',
			'@product_quantities.price',
			'*',
			'@product_quantities.multiplier',
		), 'amount_sum');

		$operations_subtraction_services = new Operation();
		$operations_subtraction_services->where('type', Operation::TYPE_SUBTRACTION);
		$operations_subtraction_services->where('subtraction_type', Operation::SUBTRACTION_TYPE_SERVICES);
		$operations_subtraction_services->where_related('service_usage', 'price >', 0);
		$operations_subtraction_services->group_start(' NOT', 'AND');
		$operations_subtraction_services->where_related('service_usage', 'service_id', NULL);
		$operations_subtraction_services->group_end();
		unset($operations_subtraction_services->db->ar_select[0]);
		$operations_subtraction_services->select_func('SUM', array(
			'@service_usages.quantity',
			'*',
			'@service_usages.price',
			'*',
			'@service_usages.multiplier',
		), 'amount_sum');

		$CI =& get_instance();

		$query = 'SELECT SUM(o.amount_sum) AS total_sum FROM ((' . $operations_subtraction_direct->get_sql() . ') UNION ALL (' . $operations_subtraction_products->get_sql() . ') UNION ALL (' . $operations_subtraction_services->get_sql() . ')) o';

		$result = $CI->db->query($query);

		return (double)$result->row()->total_sum;
	}

	/**
	 * Return if LEDCOIN in parameter are able to be transfered to attendant(s) account.
	 *
	 * @param double $ledcoin   LEDCOIN to transfer.
	 * @param double $remaining this parameter will contain remaining LEDCOIN in pool.
	 *
	 * @return bool if remaining LEDCOIN is >= to parameter $ledcoin, it can be transfered.
	 */
	function operations_ledcoin_addition_possible($ledcoin, &$remaining = 0) {
		$CI =& get_instance();
		$CI->config->load('application');
		$total      = (double)$CI->config->item('ledcoin_maximum');
		$returned   = operations_ledcoin_used();
		$transfered = operations_ledcoin_transfered();

		$remaining = $total - $transfered + $returned;

		return $ledcoin <= $remaining;
	}