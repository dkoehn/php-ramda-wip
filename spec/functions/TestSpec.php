<?php

use function PHPRamda\Functions\test;

describe('test', function() {
	it('returns true if string matches pattern', function() {
		eq(test('/^x/', 'xyz'), true);
	});

	it('returns false if string does not match pattern', function() {
		eq(test('/^y/', 'xyz'), false);
	});

	it('is referentially transparent', function() {
		pending();
//		var pattern = /x/g;
//    eq(pattern.lastIndex, 0);
//    eq(R.test(pattern, 'xyz'), true);
//    eq(pattern.lastIndex, 0);
//    eq(R.test(pattern, 'xyz'), true);
	});

	it('throws if first argument is not a regexp', function() {
		try {
			eq(test(['a'], 'a'), false);
			fail();
		} catch (\InvalidArgumentException $e) { }
	});
});