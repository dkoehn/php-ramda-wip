<?php

namespace PHPRambda\Logic {

	use const \PHPRambda\Functions\_;
	use function \PHPRambda\Internal\_curry1;
	use function \PHPRambda\Internal\_curry2;
	use function \PHPRambda\Internal\_curry3;
	use function \PHPRambda\Internal\_toArray;
	use function \PHPRambda\Internal\_arity;

	use function \PHPRambda\Functions\juxt;
	use function \PHPRambda\Math\max;

	function allPass($fns = _)
	{
		return _curry1(function($fns) {
			$max = 0;
			foreach ($fns as $fn) {
				$numArgs = _numArgs($fn);
				if ($numArgs > $max) {
					$max = $numArgs;
				}
			}

			return _arity($max, function(...$args) use ($fns) {
				foreach ($fns as $fn) {
					if (!$fn(...$args)) {
						return false;
					}
				}

				return true;
			});
		}, $fns);
	}

	// function _and($a = _, $b = _)
	// {
	// 	return _curry2(function($a, $b) {
	// 		return $a && $b;
	// 	}, $a, $b);
	// }

	function anyPass($fns = _)
	{
		return _curry1(function($fns) {
			$max = 0;
			foreach ($fns as $fn) {
				$numArgs = _numArgs($fn);
				if ($numArgs > $max) {
					$max = $numArgs;
				}
			}

			return _arity($max, function(...$args) use ($fns) {
				foreach ($fns as $fn) {
					if ($fn(...$args)) {
						return true;
					}
				}

				return false;
			});
		}, $fns);
	}

	function both($f = _, $g = _)
	{
		if (is_callable($f)) {
			return function(...$args) use ($f, $g) {
				return $f($args) && $g($args);
			};
		}

		return _curry2(function($a, $b) {
			return $a && $b;
		}, $a, $b);
	}

	function complement($fn = _)
	{
		return _curry1(function($fn) {
			return function(...$args) use ($fn) {
				return !$fn(...$args);
			};
		}, $fn);
	}

	function cond($fns = _)
	{
		return _curry1(function($fns) {
			return function(...$args) use ($fns) {
				foreach ($fns as $pairs) {
					list($predicate, $transform) = $pairs;
					if ($predicate(...$args)) {
						return $transform(...$args);
					}
				}
			};
		}, $fns);
	}

	function defaultTo($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $b ?: $a;
		}, $a, $b);
	}

	function either($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a || $b;
		}, $a, $b);
	}

	function ifElse($predicate = _, $onTrue = _, $onFalse = _)
	{
		return _curry3(function($predicate, $onTrue, $onFalse) {
			return function(...$args) use ($predicate, $onTrue, $onFalse) {
				return $predicate(...$args) ? $onTrue(...$args)
											: $onFalse(...$args);
			};
		}, $predicate, $onTrue, $onFalse);
	}

	function isEmpty($a = _)
	{
		return _curry1(function($a) {
			return empty($a);
		}, $a);
	}

	function not($a = _)
	{
		return complement($a);
	}

	// function or($a = _)
	// {
	// 	return either($a);
	// }

	// TODO: path?
	// function pathSatisfies($predicate = _, $path = _, $obj = _)
	// {
	//
	// }

	// TODO: prop?
	// function propSatisfies($predicate = _, $prop = _, $obj = _)
	// {
	//
	// }

	function unless($predicate = _, $whenFalseFn = _, $a = _)
	{
		return _curry3(function($predicate, $whenFalseFn, $a) {
			return $predicate($a) ? $a : $whenFalseFn($a);
		}, $predicate, $whenFalseFn, $a);
	}

	function until($predicate = _, $fn = _, $init = _)
	{
		return _curry3(function($predicate, $fn, $init) {
			$val = $init;
			while (!$predicate($val)) {
				$val = $fn($val);
			}
			return $val;
		}, $predicate, $fn, $init);
	}

	function when($predicate = _, $whenTrueFn = _, $a = _)
	{
		return _curry3(function($predicate, $whenFalseFn, $a) {
			return $predicate($a) ? $whenTrueFn($a) : $a;
		}, $predicate, $whenFalseFn, $a);
	}
}
