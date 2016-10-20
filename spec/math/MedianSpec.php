<?php

use function \PHPRamda\Math\median;
use const \PHPRamda\Functions\__;

describe('median', function() {
	it('returns middle value of an odd-length list', function() {
		eq(median([2]), 2);
		eq(median([2, 9, 7]), 7);
	});

	it('returns mean of two middle values of a nonempty even-length list', function() {
		eq(median([7, 2]), 4.5);
		eq(median([7, 2, 10, 9]), 8);
	});

	it('returns null for an empty list', function() {
		eq(median([]), null);
	});
});
