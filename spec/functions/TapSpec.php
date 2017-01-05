<?php

use function PHPRamda\Functions\tap;

use function PHPRamda\Functions\identity;

describe('tap', function() {
	it('returns a function that always returns its argument', function() {
		$f = tap(identity());
		eq($f(100), 100);
  });

	it("may take a function as the first argument that executes with tap's argument", function() {
		$sideEffect = 0;
		eq($sideEffect, 0);
		$rv = tap(function($x) use (&$sideEffect) { $sideEffect = 'string '.$x; }, 200);
		eq($rv, 200);
		eq($sideEffect, 'string 200');
	});
});