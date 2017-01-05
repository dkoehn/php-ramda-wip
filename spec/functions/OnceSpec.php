<?php

use function PHPRamda\Functions\once;
use function PHPRamda\Internal\_numArgs;

describe('once', function() {
	it('returns a function that calls the supplied function only the first time called', function() {
		$ctr = 0;
		$fn = once(function() use (&$ctr) { $ctr += 1; });
		$fn();
		eq($ctr, 1);
		$fn();
		eq($ctr, 1);
		$fn();
		eq($ctr, 1);
	});

	it('passes along arguments supplied', function() {
		$fn = once(function($a, $b) { return $a + $b; });
		eq($fn(5, 10), 15);
	});

	it('retains and returns the first value calculated, even if different arguments are passed later', function() {
		$ctr = 0;
		$fn = once(function($a, $b) use (&$ctr) { $ctr += 1; return $a + $b; });
		$result = $fn(5, 10);
		eq($result, 15);
		eq($ctr, 1);
		$result = $fn(20, 30);
		eq($result, 15);
		eq($ctr, 1);
	});

	it('retains arity', function() {
		$f = once(function($a, $b) { return $a + $b; });
		eq(_numArgs($f), 2);
	});
});