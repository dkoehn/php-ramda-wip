<?php

namespace PHPRamda\Math {
	use const \PHPRamda\Functions\__;
	use function \PHPRamda\Internal\_curry1;
	use function \PHPRamda\Internal\_curry2;
	use function \PHPRamda\Lists\reduce;

	function add($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			if ($a === null) { $a = 0; }
			if ($b === null) { $b = 0; }

			return $a + $b;
		}, $a, $b);
	}

	function dec($a = __)
	{
		return _curry1(function($a) {
			return $a - 1;
		}, $a);
	}

	function divide($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			if ($b === 0) {
				return null;
			}

			return $a / $b;
		}, $a, $b);
	}

	function inc($a = __)
	{
		return _curry1(function($a) {
			return $a + 1;
		}, $a);
	}

	function mathMod($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			if ($b === 0) {
				return null;
			}

			return (($a % $b) + $b) % $b;
		}, $a, $b);
	}

	function mean($list = __)
	{
		return _curry1(function($list) {
			if (count($list) === 0) {
				return null;
			}

			return sum($list) / count($list);
		}, $list);
	}

	function median($list = __)
	{
		return _curry1(function($list) {
			$len = count($list);
			if ($len === 0) {
				return null;
			}

			$width = 2 - $len % 2;
			$idx = ($len - $width) / 2;
			sort($list);
			return mean(array_slice($list, $idx, $width));
		}, $list);
	}

	function modulo($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			return $a % $b;
		}, $a, $b);
	}

	function multiply($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			return $a * $b;
		}, $a, $b);
	}

	function negate($a = __)
	{
		return _curry1(function($a) {
			return 0 - $a;
		}, $a);
	}

	function product($list = __)
	{
		return _curry1(function($list) {
			return reduce(multiply(), 1, $list);
		}, $list);
	}

	function subtract($a = __, $b = __)
	{
		return _curry2(function($a, $b) {
			return $a - $b;
		}, $a, $b);
	}

	function sum($list = __)
	{
		return _curry1(function($list) {
			return reduce(add(), 0, $list);
		}, $list);
	}
}
