<?php

use function \PHPRambda\Math\divide;
use const \PHPRambda\Functions\__;

describe('divide', function() {
	it('divides two numbers', function() {
		assertThat(divide(28, 7), equalTo(4));
		assertThat(divide(28, 0), equalTo(null));
	});

	it('is curried', function() {
		$into28 = divide(28);
		assertThat($into28(7), equalTo(4));
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$half = divide(__, 2);
		assertThat($half(40), equalTo(20));
	});
});
