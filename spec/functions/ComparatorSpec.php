<?php

use function PHPRamda\Functions\comparator;
use function PHPRamda\Lists\sort;

describe('comparator', function() {
	it('builds a comparator function for sorting out of a simple predicate that reports whether the first param is smaller', function() {
		$pred = function ($a, $b) { return $a < $b; };
		$sorter = comparator($pred);

		eq(sort($sorter, [3, 1, 8, 1, 2, 5]), [1, 1, 2, 3, 5, 8]);
	});
});