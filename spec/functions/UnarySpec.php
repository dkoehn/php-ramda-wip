<?php

use function PHPRamda\Functions\unary;

describe('unary', function() {
	it('turns multiple-argument function into unary one', function() {
		$f = unary(function($x, $y, $z) {
			eq($x, 10);
			eq($y, null);
			eq($z, null);
		});
		$f(10, 20, 30);
	});
});