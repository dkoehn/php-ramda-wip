<?php

use function \PHPRamda\Math\divide;
use const \PHPRamda\Functions\__;

describe('divide', function() {
	it('divides two numbers', function() {
		eq(divide(28, 7), 4);
		eq(divide(28, 0), null);
	});

	it('is curried', function() {
		$into28 = divide(28);
		eq($into28(7), 4);
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$half = divide(__, 2);
		eq($half(40), 20);
	});
});
