<?php

use function PHPRamda\Lists\append;

describe('append', function() {
	it('adds the element to the end of the list', function() {
		eq(append('z', ['x', 'y']), ['x', 'y', 'z']);
		eq(append(['a', 'z'], ['x', 'y']), ['x', 'y', ['a', 'z']]);
	});

	it('works on empty list', function() {
		eq(append(1, []), [1]);
	});

	it('is curried', function() {
		$append1 = append(1);
		eq($append1([4, 3, 2]), [4, 3, 2, 1]);
	});
});