<?php

namespace PHPRamda\Lists {
	use const \PHPRamda\Functions\__;
	use function \PHPRamda\Functions\compose;
	use function PHPRamda\Internal\_curry1;
	use function PHPRamda\Internal\_curry2;
	use function PHPRamda\Internal\_curry3;
	use function PHPRamda\Internal\_reduce;

	function map($fn = __, $functor = __)
	{
		return _curry2(function($fn, $functor) {
			if (is_object($functor) && method_exists($functor, 'map')) {
				return $functor->map($fn);
			} elseif (is_callable($functor)) {
				return compose($fn, $functor);
			} elseif (is_array($functor)) {
				$result = [];
				foreach ($functor as $k => $val) {
					$result[$k] = $fn($val);
				}
				return $result;
			}

			throw new \RuntimeException('Cannot map type '.gettype($functor));
		}, $fn, $functor);
	}

	function reduce($fn = __, $acc = __, $list = __)
	{
		return _curry3(function($fn, $acc, $list) {
			if (is_object($list) && method_exists($list, 'reduce')) {
				return $list->reduce($fn, $acc);
			}
			return _reduce($fn, $acc, $list);
		}, $fn, $acc, $list);
	}

	function head($list = __)
	{
		return nth(0, $list);
	}

	function last($list = __)
	{
		return nth(-1, $list);
	}

	function nth($offset = __, $list = __)
	{
		return _curry2(function($offset, $list) {
			if (is_string($list)) {
				if ($offset < 0 && abs($offset) > strlen($list)) {
					return '';
				}

				return substr($list, $offset, 1) ?: '';
			}

			if ($list === null || !is_array($list)) {
				throw new \RuntimeException('Invalid type');
			}

			if ($offset < 0 && abs($offset) > count($list)) {
				return null;
			}

			$ret = array_slice($list, $offset, 1);
			return isset($ret[0]) ? $ret[0] : null;
		}, $offset, $list);
	}

	function tail($list = __)
	{
		return _curry1(function($list) {
			if (is_string($list)) {
				return substr($list, 1) ?: '';
			}

			if ($list === null || !is_array($list)) {
				throw new \RuntimeException('Invalid type');
			}

			return array_slice($list, 1);
		}, $list);
	}
}
