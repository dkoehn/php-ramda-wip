<?php

use function PHPRamda\Functions\T;

describe('T', function() {
	it('always returns true', function() {
		eq(T(), true);
		eq(T(10), true);
		eq(T(true), true);
	});
});