<?php

namespace PHPRamda\Lists {
	use const \PHPRamda\Functions\__;
	use function \PHPRamda\Functions\compose;
	use function PHPRamda\Internal\_curry1;
	use function PHPRamda\Internal\_curry2;
	use function PHPRamda\Internal\_curry3;
	use function PHPRamda\Internal\_reduce;

	function adjust($fn = __, $idx = __, $list = __)
	{
		return _curry3(function($fn, $idx, $list) {
			if ($idx >= count($list) || $idx < 0 - count($list)) {
				return $list;
			}
			$start = $idx < 0 ? count($list) : 0;
			$_idx = $start + $idx;
			$list[$_idx] = $fn($list[$_idx]);
			return $list;
		}, $fn, $idx, $list);
	}

	function all($fn = __, $list = __)
	{
		return _curry2(function($fn, $list) {
			foreach ($list as $val) {
				if (!$fn($val)) {
					return false;
				}
			}

			return true;
		}, $fn, $list);
	}

	function any($fn = __, $list = __)
	{
		return _curry2(function($fn, $list) {
			foreach ($list as $val) {
				if ($fn($val)) {
					return true;
				}
			}

			return false;
		}, $fn, $list);
	}

	//TODO: aperture

	function append($el = __, $list = __)
	{
		return _curry2(function($el, $list) {
			$list[] = $el;
			return $list;
		}, $el, $list);
	}

	function chain($fn = __, $monad = __)
	{
		return _curry2(function($fn, $monad) {
			if (is_callable($monad)) {
				return function($x) use ($fn, $monad) {
					$fn2 = $fn($monad($x));
					return $fn2($x);
				};
			}

			$flat = \PHPRamda\Internal\_makeFlat(false);
			return $flat(map($fn, $monad));
		}, $fn, $monad);
	}

	function concat($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			if ($a === null || (is_object($a) && !method_exists($a, 'concat'))) {
				throw new \RuntimeException('Must be an array, string, or object with a concat method');
			}

			if (is_array($a) && !is_array($b)) {
				throw new \RuntimeException('Must be an array, string, or object with a concat method');
			}

			if (is_array($a)) {
				foreach ($b as $k => $v) {
					if (intval($k) === $k) {
						$a[] = $v;
					} else {
						$a[$k] = $v;
					}
				}
				return $a;
			} elseif (is_object($a) && method_exists($a, 'concat')) {
				return $a->concat($b);
			} else {
				return $a . $b;
			}
		}, $a, $b);
	}

	function contains($a = __, $list = __)
	{
		return _curry2(function($a, $list) {
			return in_array($a, $list);
		});
	}

	function head($list = __)
	{
		return nth(0, $list);
	}

	function last($list = __)
	{
		return nth(-1, $list);
	}

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

	function reduce($fn = __, $acc = __, $list = __)
	{
		return _curry3(function($fn, $acc, $list) {
			if (is_object($list) && method_exists($list, 'reduce')) {
				return $list->reduce($fn, $acc);
			}
			return _reduce($fn, $acc, $list);
		}, $fn, $acc, $list);
	}

	function sort($comparator = __, $list = __)
	{
		return _curry2(function($comparator, $list) {
			usort($list, $comparator);
			return $list;
		}, $comparator, $list);
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
