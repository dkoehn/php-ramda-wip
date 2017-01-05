<?php

use function PHPRamda\Lists\adjust;

use function PHPRamda\Math\add;

describe('adjust', function() {
	it('applies the given function to the value at the given index of the supplied array', function() {
		eq(adjust(add(1), 2, [0, 1, 2, 3]), [0, 1, 3, 3]);
	});

	it('offsets negative indexes from the end of the array', function() {
		eq(adjust(add(1), -3, [0, 1, 2, 3]), [0, 2, 2, 3]);
	});

	it('returns the original array if the supplied index is out of bounds', function() {
		$list = [0, 1, 2, 3];
		eq(adjust(add(1), 4, $list), $list);
		eq(adjust(add(1), -5, $list), $list);
	});

	it('does not mutate the original array', function() {
		$list = [0, 1, 2, 3];
		eq(adjust(add(1), 2, $list), [0, 1, 3, 3]);
		eq($list, [0, 1, 2, 3]);
	});

	it('curries the arguments', function() {
		$f = adjust(add(1));
		$f2 = $f(2);
		eq($f2([0, 1, 2, 3]), [0, 1, 3, 3]);
  });

	it('accepts an array-like object', function() {
		$fn = function() { return func_get_args(); };
		eq(adjust(add(1), 2, $fn(0, 1, 2, 3)), [0, 1, 3, 3]);
	});
});