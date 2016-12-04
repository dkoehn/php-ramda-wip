<?php

use function \PHPRamda\Math\inc;

describe('inc', function() {
	it('increments its argument', function() {
		eq(inc(-1), 0);
		eq(inc(0), 1);
		eq(inc(1), 2);
		eq(inc(12.34), 13.34);
	});
});
