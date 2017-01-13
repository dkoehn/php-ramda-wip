<?php

use function PHPRamda\Lists\concat;

use const PHPRamda\Functions\__;

describe('concat', function() {
	it('adds combines the elements of the two lists', function() {
		eq(concat(['a', 'b'], ['c', 'd']), ['a', 'b', 'c', 'd']);
		eq(concat([], ['c', 'd']), ['c', 'd']);
	});

	it('adds combines the elements of the two lists', function() {
		eq(concat(['a', 'b'], ['c', 'd']), ['a', 'b', 'c', 'd']);
		eq(concat([], ['c', 'd']), ['c', 'd']);
	});

	it('works on strings', function() {
		eq(concat('foo', 'bar'), 'foobar');
		eq(concat('x', ''), 'x');
		eq(concat('', 'x'), 'x');
		eq(concat('', ''), '');
	});

	it('delegates to non-String object with a concat method, as second param', function() {
		pending();
//	  eq(R.concat(z1, z2), 'z1 z2');
	});

	it('is curried', function() {
		$conc123 = concat([1, 2, 3]);
		eq($conc123([4, 5, 6]), [1, 2, 3, 4, 5, 6]);
		eq($conc123(['a', 'b', 'c']), [1, 2, 3, 'a', 'b', 'c']);
	});

	it('is curried like a binary operator, that accepts an initial placeholder', function() {
		$appendBar = concat(__, 'bar');
		eq(is_callable($appendBar), true);
		eq($appendBar('foo'), 'foobar');
	});

	it('throws if attempting to combine an array with a non-array', function() {
		try {
			concat([1], 2);
			fail();
		} catch (\RuntimeException $e) {}
	});

	it('throws if not an array, String, or object with a concat method', function() {
		try {
			concat(new \stdClass(), 'a');
			fail();
		} catch (\RuntimeException $e) {}
	});
});