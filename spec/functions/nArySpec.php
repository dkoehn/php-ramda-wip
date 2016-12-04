<?php

use function PHPRamda\Functions\nAry;
use function PHPRamda\Internal\_numArgs;

describe('nAry', function() {

	$toArray = function($args) { return array_slice($args, 0); };

	it('turns multiple-argument function into a nullary one', function() use ($toArray) {
		$fn = nAry(0, function($x, $y, $z) use ($toArray) { return $toArray(func_get_args()); });
		eq(_numArgs($fn), 0);
		eq($fn(1, 2, 3), [null, null, null]);
	});

	it('turns multiple-argument function into a ternary one', function() use ($toArray) {
		$fn = nAry(3, function($a, $b, $c, $d) { return func_get_args(); });
		eq(_numArgs($fn), 3);
		eq($fn(1, 2, 3, 4), [1, 2, 3, null]);
		eq($fn(1), [1, null, null, null]);
	});

//	it('creates functions of arity less than or equal to ten', function() {
//		var fn = R.nAry(10, function() { return toArray(arguments); });
//		eq(fn.length, 10);
//		eq(fn.apply(null, R.range(0, 25)), R.range(0, 10));
//
//		var undefs = fn();
//		var ns = R.repeat(undefined, 10);
//		eq(undefs.length, ns.length);
//		var idx = undefs.length - 1;
//		while (idx >= 0) {
//			eq(undefs[idx], ns[idx]);
//			idx -= 1;
//		}
//	});
//
//	it('throws if n is greater than ten', function() {
//		assert.throws(function() {
//			R.nAry(11, function() {});
//		}, function(err) {
//			return (err instanceof Error &&
//				err.message === 'First argument to nAry must be a non-negative integer no greater than ten');
//		});
//	});

});