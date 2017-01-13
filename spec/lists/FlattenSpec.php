<?php

use function PHPRamda\Lists\flatten;

describe('flatten', function() {
	it('turns a nested list into one flat list', function() {
		$nest = [1, [2], [3, [4, 5], 6, [[[7], 8]]], 9, 10];
		eq(flatten($nest), [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$nest = [[[[3]], 2, 1], 0, [[-1, -2], -3]];
		eq(flatten($nest), [3, 2, 1, 0, -1, -2, -3]);
		eq(flatten([1, 2, 3, 4, 5]), [1, 2, 3, 4, 5]);
	});

	it('is not destructive', function() {
		pending();
		$nest = [1, [2], [3, [4, 5], 6, [[[7], 8]]], 9, 10];
		//assert.notStrictEqual(flatten($nest), $nest);
	});

	it('handles ridiculously large inputs', function() {
		pending();
//		this.timeout(10000);
//		eq(R.flatten([new Array(1000000), R.range(0, 56000), 5, 1, 3]).length, 1056003);
  });

	it('handles array-like objects', function() {
		pending();
//		var o = {length: 3, 0: [1, 2, [3]], 1: [], 2: ['a', 'b', 'c', ['d', 'e']]};
//    eq(R.flatten(o), [1, 2, 3, 'a', 'b', 'c', 'd', 'e']);
  });

	it('flattens an array of empty arrays', function() {
		eq(flatten([[], [], []]), []);
		eq(flatten([]), []);
	});

});