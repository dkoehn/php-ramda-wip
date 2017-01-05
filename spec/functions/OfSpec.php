<?php

use function PHPRamda\Functions\of;

describe('of', function() {
	it('returns its argument as an Array', function() {
		eq(of(100), [100]);
		eq(of([100]), [[100]]);
		eq(of(null), [null]);
		eq(of([]), [[]]);
	});
});