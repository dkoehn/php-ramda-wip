<?php

use function PHPRamda\Lists\drop;

describe('drop', function() {

	it('skips the first `n` elements from a list, returning the remainder', function() {
		eq(drop(3, ['a', 'b', 'c', 'd', 'e', 'f', 'g']), ['d', 'e', 'f', 'g']);
	});

	it('returns an empty array if `n` is too large', function() {
		eq(drop(20, ['a', 'b', 'c', 'd', 'e', 'f', 'g']), []);
	});

	it('returns an equivalent list if `n` is <= 0', function() {
		eq(drop(0, [1, 2, 3]), [1, 2, 3]);
		eq(drop(-1, [1, 2, 3]), [1, 2, 3]);
		eq(drop(-999999999999, [1, 2, 3]), [1, 2, 3]);
	});

	it('never returns the input array', function() {
		pending();
		$xs = [1, 2, 3];
		eq(drop(0, $xs) === $xs, false);
		eq(drop(-1, $xs) === $xs, false);
	});

	it('can operate on strings', function() {
		eq(drop(3, 'Ramda'), 'da');
		eq(drop(4, 'Ramda'), 'a');
		eq(drop(5, 'Ramda'), '');
		eq(drop(6, 'Ramda'), '');
	});
});