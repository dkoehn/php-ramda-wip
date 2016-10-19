<?php

use function \PHPRamda\Math\multiply;
use const \PHPRamda\Functions\__;

describe('multiply', function() {
	it('multiplies two numbers', function() {
		assertThat(multiply(6, 7), equalTo(42));
	});

	it('is curried', function() {
		$dbl = multiply(2);
		assertThat($dbl(15), equalTo(30));
	});
});
