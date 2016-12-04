<?php

use function \PHPRamda\Math\negate;

describe('negate', function() {
	it('negates its argument', function() {
		eq(negate(-1), 1);
		eq(negate(0), 0);
		eq(negate(1), -1);
	});
});
