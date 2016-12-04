<?php

namespace PHPRamda\Functions {
	use function \PHPRamda\Internal\_arity;
	use function \PHPRamda\Internal\_curry1;
	use function \PHPRamda\Internal\_curry2;
	use function \PHPRamda\Internal\_curryN;
	use function \PHPRamda\Internal\_numArgs;
	use function \PHPRamda\Internal\_pipe;
	use function \PHPRamda\Internal\_slice;

	use function \PHPRamda\Lists\reduce;
	use function \PHPRamda\Lists\tail;

	const __ = '__PLACHOLDER__';

	function addIndex($fn = __)
	{
		return _curry1(function($fn) {
			return curryN(_numArgs($fn), function(... $arguments) use ($fn) {
				$idx = 0;
				$origFn = $arguments[0];
				$list = $arguments[count($arguments) - 1];
				$args = _slice($arguments);
				$args[0] = function(... $arguments) use ($origFn, &$idx, $list) {
					$newArgs = array_merge($arguments, [$idx, $list]);
					$result = $origFn(... $newArgs);
					$idx += 1;
					return $result;
				};

				return $fn(... $args);
			});
		}, $fn);
	}

	function always($val = __)
	{
		return _curry1(function($val) {
			return function() use ($val) {
				return $val;
			};
		}, $val);
	}

	function ap($applicative = __, $fn = __)
	{
		return _curry2(function($applicative, $fn) {
			if (is_object($applicative) && method_exists($applicative, 'ap')) {
				return $applicative->ap($fn);
			} elseif (is_callable($applicative)) {
				return function($x) use ($applicative, $fn) {
					$appliedFn = $applicative($x);
					return $appliedFn($fn($x));
				};
			}

			$ret = [];
			foreach ($applicative as $f) {
				foreach ($fn as $val) {
					$ret[] = $f($val);
				}
			}
			return $ret;
		}, $applicative, $fn);
	}

	function apply($fn = __, $list = __)
	{
		return _curry2(function($fn, $list) {
			return $fn(...$list);
		}, $fn, $list);
	}

	//TODO: applySpec
	//function applySpec()

	function binary($fn = __)
	{
		return nAry(2, $fn);
	}

	//TODO: bind
	//function bind()

	function comparator($pred = __)
	{
		return _curry1(function($pred) {
			return function($a, $b) use ($pred) {
				return $pred($a, $b) ? -1 : ($pred($b, $a) ? 1 : 0);
			};
		}, $pred);
	}

	function compose(...$args)
	{
		if (count($args) === 0) {
			throw new \Exception('compose requires at least one argument');
		}

		$reversedArgs = array_reverse($args);
		return pipe(...$reversedArgs);
	}

	function curry(callable $fn, ...$params)
	{
		$args = array_merge([$fn], $params);
		return _curry1(function($fn, ...$params) {
			return curryN(_numArgs($fn), $fn, ...$params);
		}, ...$args);
	}

	function nAry($n = __, $fn = __)
	{
		return _curry2(function($n, $fn) {
			$numArgs = _numArgs($fn);
			$callFn = function($args) use ($n, $fn, $numArgs) {
				if ($numArgs > count($args)) {
					for ($i = count($args); $i < $numArgs; $i++) {
						$args[] = null;
					}
				} else {
					$args = array_slice($args, 0, $numArgs);
				}

				return $fn(...$args);
			};
			switch ($n) {
				case 0:
					return function() use ($callFn) { return $callFn([]); };
				case 1:
					return function($a) use ($callFn) { return $callFn([$a]); };
				case 2:
					return function($a, $b) use ($callFn) { return $callFn([$a, $b]); };
				case 3:
					return function($a = null, $b = null, $c = null) use ($callFn) { return $callFn([$a, $b, $c]); };
				case 4:
					return function($a, $b, $c, $d) use ($callFn) { return $callFn([$a, $b, $c, $d]); };
				case 5:
					return function($a, $b, $c, $d, $e) use ($callFn) { return $callFn([$a, $b, $c, $d, $e]); };
				case 6:
					return function($a, $b, $c, $d, $e, $f) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f]); };
				case 7:
					return function($a, $b, $c, $d, $e, $f, $g) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g]); };
				case 8:
					return function($a, $b, $c, $d, $e, $f, $g, $h) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h]); };
				case 9:
					return function($a, $b, $c, $d, $e, $f, $g, $h, $i) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h, $i]); };
				case 10:
					return function($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h, $i, $j]); };
				default:
					throw new \RuntimeException('First argument to nAry must be a non-negative integer no greater than ten');
			}
		}, $n, $fn);
	}

	function pipe(...$args)
	{
		if (count($args) === 0) {
			throw new \Exception('pipe requires at least one argument');
		}

		$numArgs = _numArgs($args[0]);
		return _arity($numArgs, reduce(_pipe(), $args[0], tail($args)));
	}

	function curryN($arity, callable $fn, ...$params)
	{
		if ($arity === 1) {
			return _curry1($fn, $params);
		}

		return _arity($arity, _curryN($arity, $params, $fn));
	}
}
