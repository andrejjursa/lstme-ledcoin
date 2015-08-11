<?php

	/**
	 * Returns text based on number.
	 *
	 * @param int    $number    number which is used to determine text to return.
	 * @param string $for_zero  text if number is zero.
	 * @param string $for_one   text if number is one.
	 * @param string $for_two   text if number is two.
	 * @param string $for_three text if number is three.
	 * @param string $for_four  text if number is four.
	 * @param string $otherwise text if number is else than any previous.
	 *
	 * @return string text based on number.
	 */
	function get_inflection_by_numbers($number, $for_zero, $for_one, $for_two, $for_three, $for_four, $otherwise) {
		switch ((int)$number) {
			case 0:
				return $for_zero;
			case 1:
				return $for_one;
			case 2:
				return $for_two;
			case 3:
				return $for_three;
			case 4:
				return $for_four;
		}

		return $otherwise;
	}

	/**
	 * Return slovak text for LEDCOIN based on parameter value.
	 *
	 * @param double $value amount of LEDCOIN.
	 *
	 * @return string LEDCOIN word based on inflection.
	 */
	function get_inflection_ledcoin($value) {
		$abs_value = abs($value);
		if ($abs_value == 1.0) {
			return 'LEDCOIN';
		} elseif ($abs_value == 2.0 || $abs_value == 3.0 || $abs_value == 4.0) {
			return 'LEDCOIN-y';
		} else {
			return 'LEDCOIN-ov';
		}
	}

	/**
	 * Recursively delete a directory.
	 *
	 * @param string  $dir             directory name.
	 * @param boolean $delete_root_too delete specified top-level directory as well.
	 */
	function unlink_recursive($dir, $delete_root_too) {
		if (!$dh = @opendir($dir)) {
			return;
		}

		while (FALSE !== ($obj = readdir($dh))) {
			if ($obj == '.' || $obj == '..') {
				continue;
			}

			if (!@unlink($dir . '/' . $obj)) {
				unlink_recursive($dir . '/' . $obj, TRUE);
			}
		}

		closedir($dh);

		if ($delete_root_too) {
			@rmdir($dir);
		}

		return;
	}

	/**
	 * Returns path to person minified photo.
	 *
	 * @param int $person_id person id.
	 *
	 * @return string path to photo.
	 */
	function get_person_image_min($person_id) {
		$path = 'user/photos/data/' . (int)$person_id . '/';
		if (file_exists($path)) {
			if (file_exists($path . 'photo.png')) {
				if (file_exists($path . 'photo_min.png')) {
					return base_url($path . 'photo_min.png');
				} else {
					$resize_config = array('image_library' => 'gd2', 'source_image' => $path . 'photo.png', 'create_thumb' => FALSE, 'maintain_ratio' => TRUE, 'width' => 48, 'height' => 48, 'quality' => '90%', 'new_image' => $path . 'photo_min.png',);
					$CI            =& get_instance();
					$CI->load->library('image_lib');
					$CI->image_lib->initialize($resize_config);
					if ($CI->image_lib->resize()) {
						return base_url($resize_config['new_image']);
					} else {
						return base_url('user/photos/default/photo_min.png');
					}
				}
			} else {
				return base_url('user/photos/default/photo_min.png');
			}
		} else {
			return base_url('user/photos/default/photo_min.png');
		}
	}

	function get_product_image_min($product_id) {
		$path = 'user/products/data/' . (int)$product_id . '/';
		if (file_exists($path)) {
			if (file_exists($path . 'product.png')) {
				if (file_exists($path . 'product_min.png')) {
					return base_url($path . 'product_min.png');
				} else {
					$resize_config = array('image_library' => 'gd2', 'source_image' => $path . 'product.png', 'create_thumb' => FALSE, 'maintain_ratio' => TRUE, 'width' => 48, 'height' => 48, 'quality' => '90%', 'new_image' => $path . 'product_min.png',);
					$CI            =& get_instance();
					$CI->load->library('image_lib');
					$CI->image_lib->initialize($resize_config);
					if ($CI->image_lib->resize()) {
						return base_url($resize_config['new_image']);
					} else {
						return base_url('user/products/default/product_min.png');
					}
				}
			} else {
				return base_url('user/products/default/product_min.png');
			}
		} else {
			return base_url('user/products/default/product_min.png');
		}
	}