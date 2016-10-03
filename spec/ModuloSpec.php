<?php

use function \PHPRambda\Math\modulo;
use const \PHPRambda\Functions\__;

describe('modulo', function() {
	it('divides the first param by the second and returns the remainder', function() {
		assertThat(modulo(100, 2), equalTo(0));
		assertThat(modulo(100, 3), equalTo(1));
		assertThat(modulo(100, 17), equalTo(15));
	});

	it('is curried', function() {
		$hundredMod = modulo(100);
		assertThat($hundredMod(2), equalTo(0));
		assertThat($hundredMod(3), equalTo(1));
		assertThat($hundredMod(17), equalTo(15));
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$isOdd = modulo(__, 2);
		assertThat($isOdd(3), equalTo(1));
		assertThat($isOdd(198), equalTo(0));
	});

	it('preserves javascript-style modulo evaluation for negative numbers', function() {
		assertThat(modulo(-5, 4), equalTo(-1));
	});
});
