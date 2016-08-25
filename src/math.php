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

	function mean($list = _)
	{
		return _curry1(function($list) {
			return sum($list) / count($list);
		}, $list);
	}

	function modulo($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a % $b;
		}, $a, $b);
	}

	function negate($a = _)
	{
		return _curry1(function($a) {
			return 0 - $a;
		});
	}

	function product($list = _)
	{
		return _curry1(function($list) {
			$ret = 1;
			foreach ($list as $v) {
				$ret *= $v;
			}
			return $ret;
		});
	}

	function subtract($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a - $b;
		}, $a, $b);
	}

	function sum($list = _)
	{
		return _curry1(function($list) {
			$ret = 0;
			foreach ($list as $v) {
				$ret += $v;
			}
			return $ret;
		}, $list);
	}

	function multiply($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a * $b;
		}, $a, $b);
	}

	function pow($a = _, $b = _)
	{
		return _curry2(function($a, $b) {
			return $a ** $b;
		}, $a, $b);
	}
}
