<?php

use function PHPRamda\Lists\all;

use function PHPRamda\Functions\T;

describe('all', function() {
	$even = function($n) { return $n % 2 === 0; };
	$isFalse = function($x) { return $x === false; };

	it('returns true if all elements satisfy the predicate', function() use ($even, $isFalse) {
		eq(all($even, [2, 4, 6, 8, 10, 12]), true);
		eq(all($isFalse, [false, false, false]), true);
	});

	it('returns false if any element fails to satisfy the predicate', function() use ($even) {
		eq(all($even, [2, 4, 6, 8, 9, 10]), false);
	});

	it('returns true for an empty list', function() {
		eq(all(T(), []), true);
	});

	it('is curried', function() use ($even) {
		$count = 0;
		$test = function($n) use (&$count, $even) { $count += 1; return $even($n); };
		$at = all($test);
		eq($at([2, 4, 6, 7, 8, 10]), false);
	});
});