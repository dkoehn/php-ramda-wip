<?php

namespace PHPRambda\Logic {

	use const \PHPRambda\Functions\_;
	use function \PHPRambda\Internal\_curry2;

	function _and($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a && $b;
		}, $a, $b);
	}

	function both($f = _, $g = _)
	{
		if (is_callable($f)) {
			return function(...$args) use ($f, $g) {
				return $f($args) && $g($args);
			};
		}

		return _and($f, $g);
	}
}
