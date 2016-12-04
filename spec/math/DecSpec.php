<?php

use function \PHPRamda\Math\dec;

describe('dec', function() {
	it('decrements its argument', function() {
		eq(dec(-1), -2);
		eq(dec(0), -1);
		eq(dec(1), 0);
		eq(dec(12.34), 11.34);
	});
});
