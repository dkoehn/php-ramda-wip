<?php

namespace PHPRambda\Math {

	use const \PHPRambda\Functions\_;
	use function \PHPRambda\Internal\_curry1;
	use function \PHPRambda\Internal\_curry2;

	function add($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a + $b;
		}, $a, $b);
	}

	function dec($a = _)
	{
		return _curry1(function($a) {
			return $a - 1;
		}, $a);
	}

	function divide($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			if ($b === 0) {
				throw new \DivisionByZeroError();
			}

			return $a / $b;
		}, $a, $b);
	}

	function inc($a = _)
	{
		return _curry1(function($a) {
			return $a + 1;
		}, $a);
	}

	function mathMod($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return (($a % $b) + $b) % $b;
		}, $a, $b);
	}

	function subtract($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a - $b;
		}, $a, $b);
	}

	function multiply($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a * $b;
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

	function pow($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a ** $b;
		}, $a, $b);
	}
}
