<?php

use function \PHPRamda\Math\mean;
use const \PHPRamda\Functions\__;

describe('mean', function() {
	it('returns mean of a nonemtpy list', function() {
		eq(mean([2]), 2);
		eq(mean([2, 7]), 4.5);
		eq(mean([2, 7, 9]), 6);
		eq(mean([2, 7, 9, 10]), 7);
	});

	it('returns null for an empty list', function() {
		eq(mean([]), null);
	});
});
