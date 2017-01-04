<?php

use function PHPRamda\Functions\juxt;

use function PHPRamda\Math\add;
use function PHPRamda\Math\multiply;
use function PHPRamda\Functions\nAry;
use function PHPRamda\Functions\T;
use function PHPRamda\Internal\_numArgs;

describe('juxt', function() {
	$hello = function() {
		return 'hello';
	};

	$bye = function() {
		return 'bye';
	};

	it('works with no functions and no values', function() {
		$j = juxt([]);
		eq($j(), []);
	});

	it('works with no functions and some values', function() {
		$j = juxt([]);
		eq($j(2, 3), []);
	});

	it('works with 1 function and no values', function() use ($hello) {
		$j = juxt([$hello]);
		eq($j(), ['hello']);
	});

	it('works with 1 function and 1 value', function() {
		$j = juxt([add(3)]);
		eq($j(2), [5]);
	});

	it('works with 1 function and some values', function() {
		$j = juxt([multiply()]);
		eq($j(2, 3), [6]);
	});

	it('works with some functions and no values', function() use ($hello, $bye) {
		$j = juxt([$hello, $bye]);
		eq($j(), ['hello', 'bye']);
	});

	it('works with some functions and 1 value', function() {
		$j = juxt([multiply(2), add(3)]);
		eq($j(2), [4, 5]);
	});

	it('works with some functions and some values', function() {
		$j = juxt([add(), multiply()]);
		eq($j(2, 3), [5,6]);
	});

	it('retains the highest arity', function() {
		$a = function($a) { return $a; };
		$f = juxt([nAry(1, $a), nAry(3, $a), nAry(2, $a)]);

		eq(_numArgs($f), 3);
	});

	it('returns a curried function', function() {
		$j = juxt([multiply(), add()]);
		$j2 = $j(2);
		eq($j2(3), [6, 5]);
	});
});