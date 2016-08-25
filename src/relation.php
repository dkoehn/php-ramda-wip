<?php

namespace PHPRambda\Relation {
	use const \PHPRambda\Functions\_;
	use function \PHPRambda\Internal\_curry1;
	use function \PHPRambda\Internal\_curry2;
	use function \PHPRambda\Internal\_curry3;

	function clamp($min = _, $max = _, $x = _)
	{
		return _curry3(function($min, $max, $x) {
			if ($min > $max) {
				throw new \RuntimeException('min must not be greater than max');
			}

			return value < min ? min :
				value > max ? max :
				value;
		}, $min, $max, $x);
	}

	//TODO: reduceBy
	// function countBy($keyFn = _, $list = _) {
	//
	// }

	function difference($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			$out = [];
			$idx = 0;
			while ($idx < count($a)) {
				if (!in_array($a[$idx], $b) && !in_array($a[$idx], $out)) {
					$out[] = $a[$idx];
					yield $a[$idx];
				}
				$idx++;
			}
		}, $a, $b);
	}

	//TODO:
	// function differenceWith($comparator = _, $a = _, $b = _)
	// {
	// 	return _curry3(function($comparator, $a, $b) {
	//
	// 	}, $comparator, $a, $b);
	// }

	function eqBy($fn = _, $a = _, $b = _)
	{
		return _curry3(function($fn, $a, $b) {
			return equals($fn($a), $fn($b));
		}, $fn, $a, $b);
	}

	function equals($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a == $b;
		});
	}

	function gt($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a > $b;
		}, $a, $b);
	}

	function gte($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a >= $b;
		}, $a, $b);
	}

	function identical($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a === $b;
		}, $a, $b);
	}

	function intersection($a = _, $b= _)
	{
		return _curry2(function($a, $b) {
			if (count($a) > count($b)) {
				$lookupList = $a;
				$filteredList = $b;
			} else {
				$lookupList = $b;
				$filteredList = $a;
			}

			$out = [];
			$idx = 0;
			while ($idx < count($lookupList)) {
				if (in_array($lookupList[$idx], $filteredList)
					&& !in_array($lookupList[$idx], $out)) {
					$out[] = $lookupList[$idx];
					yield $lookupList[$idx];
				}
				$idx++;
			}
		}, $a, $b);
	}

	//TODO:
	// function intersectionWith($a = _, $b= _)
	// {
	// }

	function lt($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a < $b;
		}, $a, $b);
	}

	function lte($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a <= $b;
		}, $a, $b);
	}

	function max(...$args)
	{
		$max = function(...$args) {
			if (count($args) === 0) {
				return null;
			}

			if (count($args) === 1 && is_array($args[0])) {
				$args = $args[0];
			}

			$max = $args[0];
			for ($i = 1; $i < count($args); $i++) {
				if ($args[$i] > $max) {
					$max = $args[$i];
				}
			}
			return $max;
		};

		if (count($args)) {
			if (count($args) === 1 && is_array($args[0])) {
				$args = $args[0];
			}

			return $max(...$args);
		}

		return $max;
	}

	function min(...$args)
	{
		$min = function(...$args) {
			if (count($args) === 0) {
				return null;
			}

			if (count($args) === 1 && is_array($args[0])) {
				$args = $args[0];
			}

			$min = $args[0];
			for ($i = 1; $i < count($args); $i++) {
				if ($args[$i] < $min) {
					$min = $args[$i];
				}
			}
			return $min;
		};

		if (count($args)) {
			if (count($args) === 1 && is_array($args[0])) {
				$args = $args[0];
			}

			return $min(...$args);
		}

		return $min;
	}

	function symmetricDifference($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			foreach (difference($a, $b) as $v) {
				yield $v;
			}
			foreach (difference($b, $a) as $v) {
				yield $v;
			}
		}, $a, $b);
	}
}
