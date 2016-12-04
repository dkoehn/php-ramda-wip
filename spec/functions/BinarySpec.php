<?php

use function PHPRamda\Functions\binary;
use function PHPRamda\Internal\_numArgs;

describe('binary', function() {
	it('turns multiple-argument function into binary one', function() {
		$fn = function($x, $y, $z) {
			return [$x, $y, $z];
		};

		$fn2 = binary($fn);
		eq(_numArgs($fn2), 2);
		eq($fn2(10, 20, 30), [10, 20, null]);
	});

	it('turns a void function into binary one', function() {
		$fn = function() {
			return [];
		};

		$fn2 = binary($fn);
		eq(_numArgs($fn2), 2);
		eq($fn2(10, 20), []);
	});

	it('turns unary function into binary one', function() {
		$fn = function($a) {
			return [$a];
		};

		$fn2 = binary($fn);
		eq(_numArgs($fn2), 2);
		eq($fn2(10, 20), [10]);
	});
});
