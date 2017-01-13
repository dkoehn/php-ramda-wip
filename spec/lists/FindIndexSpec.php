<?php

use function PHPRamda\Lists\findIndex;

describe('findIndex', function() {
//	$obj1 = ['x' => 100];
//	$obj2 = ['x' => 200];
	$a = [11, 10, 9, 'cow', 8, 7, 100, 200, 300, 4, 3, 2, 1, 0];
	$even = function($x) {
		if (is_string($x)) { return false; }
		return $x % 2 === 0;
	};
	$gt100 = function($x) {
		return $x > 100;
	};
	$isStr = function($x) {
		return is_string($x);
	};
//  var xGt100 = function(o) { return o && o.x > 100; };
//  var intoArray = R.into([]);

	it('returns the index of the first element that satisfies the predicate', function() use ($even, $gt100, $isStr, $a) {
		eq(findIndex($even, $a), 1);
		eq(findIndex($gt100, $a), 7);
		eq(findIndex($isStr, $a), 3);
//		eq(findIndex(xGt100, a), 10);
	});

	it('returns the index of the first element that satisfies the predicate into an array', function() {
		pending();
//	  eq(intoArray(R.findIndex(even), a), [1]);
//	  eq(intoArray(R.findIndex(gt100), a), [8]);
//	  eq(intoArray(R.findIndex(isStr), a), [3]);
//	  eq(intoArray(R.findIndex(xGt100), a), [10]);
	});

	it('returns -1 when no element satisfies the predicate', function() use ($even) {
	  eq(findIndex($even, ['zing']), -1);
	  eq(findIndex($even, []), -1);
	});

	it('returns -1 in array when no element satisfies the predicate into an array', function() use ($even) {
		pending();
//	  eq(intoArray(R.findIndex(even), ['zing']), [-1]);
	});

	it('is curried', function() use ($even, $a) {
		$findEvenIndex = findIndex($even);
		eq(is_callable($findEvenIndex), true);
		eq($findEvenIndex($a), 1);
	});

});