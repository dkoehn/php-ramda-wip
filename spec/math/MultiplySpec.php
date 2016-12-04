<?php

use function \PHPRamda\Math\multiply;
use const \PHPRamda\Functions\__;

describe('multiply', function() {
	it('multiplies two numbers', function() {
		eq(multiply(6, 7), 42);
	});

	it('is curried', function() {
		$dbl = multiply(2);
		eq($dbl(15), 30);
	});
});
