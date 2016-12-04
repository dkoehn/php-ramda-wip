<?php

use function PHPRamda\Functions\apply;

describe('apply', function() {
	$max = function(...$args) {
		$val = null;
		foreach ($args as $a) {
			if ($val === null || $a > $val) {
				$val = $a;
			}
		}
		return $val;
	};

	it('applies function to argument list', function() use ($max) {
		eq(apply($max, [1, 2, 3, -99, 42, 6, 7]), 42);
	});

	it('is curried', function() use ($max) {
		$applyMax = apply($max);
		eq($applyMax([1, 2, 3, -99, 42, 6, 7]), 42);
	});
});