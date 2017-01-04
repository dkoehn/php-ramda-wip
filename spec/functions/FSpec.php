<?php

use function PHPRamda\Functions\F;

describe('F', function() {
	it('always returns false', function() {
		eq(F(), false);
		eq(F(10), false);
		eq(F(true), false);
	});
});