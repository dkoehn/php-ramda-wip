<?php

use function PHPRamda\Lists\any;

use function PHPRamda\Functions\T;

describe('any', function() {
	$odd = function($n) { return $n % 2 === 1; };

	it('returns true if any element satisfies the predicate', function() use ($odd) {
		eq(any($odd, [2, 4, 6, 8, 10, 11, 12]), true);
	});

	it('returns false if all elements fail to satisfy the predicate', function() use ($odd) {
		eq(any($odd, [2, 4, 6, 8, 10, 12]), false);
	});

	it('returns false for an empty list', function() {
		eq(any(T(), []), false);
	});

	it('is curried', function() use ($odd) {
		$count = 0;
		$test = function($n) use (&$count, $odd) { $count += 1; return $odd($n); };
		$at = any($test);
		eq($at([2, 4, 6, 7, 8, 10]), true);
	});
});