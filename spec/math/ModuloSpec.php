<?php

use function \PHPRamda\Math\modulo;
use const \PHPRamda\Functions\__;

describe('modulo', function() {
	it('divides the first param by the second and returns the remainder', function() {
		eq(modulo(100, 2), 0);
		eq(modulo(100, 3), 1);
		eq(modulo(100, 17), 15);
	});

	it('is curried', function() {
		$hundredMod = modulo(100);
		eq($hundredMod(2), 0);
		eq($hundredMod(3), 1);
		eq($hundredMod(17), 15);
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$isOdd = modulo(__, 2);
		eq($isOdd(3), 1);
		eq($isOdd(198), 0);
	});

	it('preserves javascript-style modulo evaluation for negative numbers', function() {
		eq(modulo(-5, 4), -1);
	});
});
