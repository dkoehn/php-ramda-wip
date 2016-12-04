<?php

use function \PHPRamda\Math\subtract;
use const \PHPRamda\Functions\__;

describe('subtract', function() {
	it('subtracts two numbers', function() {
		eq(subtract(22, 7), 15);
	});

	it('coerces its arguments to numbers', function() {
		eq(subtract('1', '2'), -1);
		eq(subtract(1, '2'), -1);
		eq(subtract(true, false), 1);
		eq(subtract(null, null), 0);
	});

	it('is curried', function() {
		$ninesCompl = subtract(9);
		eq($ninesCompl(6), 3);
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$minus5 = subtract(__, 5);
		eq($minus5(17), 12);
	});
});
