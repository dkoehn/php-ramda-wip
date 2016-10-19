<?php

use function \PHPRamda\Math\add;

describe('add', function() {
	it('adds together two numbers', function() {
		eq(add(3, 7), 10);
	});

	it('coerces its arguments to numbers', function() {
		eq(add('1', '2'), 3);
		eq(add(1, '2'), 3);
		eq(add(true, false), 1);
		eq(add(null, null), 0);
	});
	it('is curried', function() {
		$incr = add(1);
		eq($incr(42), 43);
	});
});
