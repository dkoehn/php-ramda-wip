<?php

namespace PHPRamda\Functions {
	use function \PHPRamda\Internal\_arity;
	use function \PHPRamda\Internal\_curry1;
	use function \PHPRamda\Internal\_curry2;
	use function \PHPRamda\Internal\_curryN;
	use function \PHPRamda\Internal\_numArgs;
	use function \PHPRamda\Internal\_pipe;

	use function \PHPRamda\Lists\reduce;
	use function \PHPRamda\Lists\tail;

	const __ = '__PLACHOLDER__';

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
		return _curry1(function($fn) {
			return curryN(_numArgs($fn), $fn);
		}, $fn, ...$params);
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
			return _curry1($fn);
		}

		return _arity($arity, _curryN($arity, $params, $fn));
	}
}
