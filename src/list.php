<?php

namespace PHPRambda\Lists {

	use const PHPRambda\Functions\_;
	use function PHPRambda\Internal\_curry1;
	use function PHPRambda\Internal\_curry2;
	use function PHPRambda\Internal\_curry3;
	use function PHPRambda\Internal\_reduce;

	function each($fn = _, $list = _)
	{
		return _curry2(function($fn, $list) {
			foreach ($list as $k => $v) {
				yield $k => $fn($v);
			}
		}, $fn, $list);
	}

	function map($fn = _, $list = _)
	{
		return _curry2(function($fn, $list) {
			foreach ($list as $k => $val) {
				yield $k => $fn($val);
			}
		}, $fn, $list);
	}

	function nth($n = _, $list = _)
	{
		return _curry2(function($n, $list) {
			if (is_string($list)) {
				return substr($list, $n, 1);
			}

			$ret = array_slice($list, $n, 1);
			return $ret ? $ret[0] : null;
		}, $n, $list);
	}

	function reduce($fn = _, $acc = _, $list = _)
	{
		return _curry3(function($fn, $acc, $list) {
			return _reduce($fn, $acc, $list);
		}, $fn, $acc, $list);
	}

	function reverse($list = _)
	{
		return _curry1(function($list) {
			if (is_string($list)) {
				$list = str_split($list);
			}

			return array_reverse($list);
		}, $list);
	}

	function tail($list = _)
	{
		return _curry1(function($list) {
			return array_slice($list, 1, count($list));
		}, $list);
	}
}