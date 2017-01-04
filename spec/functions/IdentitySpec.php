<?php

use function PHPRamda\Functions\identity;

describe('identity', function() {
	it('returns its first argument', function() {
		eq(identity(null), null);
		eq(identity('foo'), 'foo');
		eq(identity('foo', 'bar'), 'foo');
	});

	it('has length 1', function() {
		eq(\PHPRamda\Internal\_numArgs(identity()), 1);
	});
});