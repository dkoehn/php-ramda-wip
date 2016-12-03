<?php

namespace PHPRamda\Object {

	use const \PHPRamda\Functions\__;
	use function \PHPRamda\Internal\_curry2;
	use function \PHPRamda\Internal\_curry3;

	function prop($p = __, $obj = __)
	{
		return _curry2(function($p, $obj) {
			return array_key_exists($p, $obj)
				? $obj[$p]
				: null;
		}, $p, $obj);
	}

	function propOr($val = __, $p = __, $obj = __)
	{
		return _curry3(function($val, $p, $obj) {
			return ($obj !== null && array_key_exists($p, $obj))
				? $obj[$p]
				: $val;
		}, $val, $p, $obj);
	}
}
