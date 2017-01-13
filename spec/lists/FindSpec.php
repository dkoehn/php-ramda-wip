<?php

use function PHPRamda\Lists\find;

describe('find', function() {
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

	it('returns the first element that satisfies the predicate', function() use ($even, $gt100, $isStr, $a) {
	  eq(find($even, $a), 10);
	  eq(find($gt100, $a), 200);
	  eq(find($isStr, $a), 'cow');
//	  eq(R.find(xGt100, a), obj2);
	});

	it('transduces the first element that satisfies the predicate into an array', function() {
		pending();
//	  eq(intoArray(R.find(even), a), [10]);
//	  eq(intoArray(R.find(gt100), a), [200]);
//	  eq(intoArray(R.find(isStr), a), ['cow']);
//	  eq(intoArray(R.find(xGt100), a), [obj2]);
	});

	it('returns `undefined` when no element satisfies the predicate', function() use ($even) {
	  eq(find($even, ['zing']), null);
	});

	it('returns `undefined` in array when no element satisfies the predicate into an array', function() {
		pending();
//	  eq(intoArray(R.find(even), ['zing']), [undefined]);
	});

	it('returns `undefined` when given an empty list', function() use ($even) {
	  eq(find($even, []), null);
	});

	it('returns `undefined` into an array when given an empty list', function() {
		pending();
//	  eq(intoArray(R.find(even), []), [undefined]);
	});

	it('is curried', function() use ($even, $a) {
		$findEven = find($even);
		eq(is_callable($findEven), true);
		eq($findEven($a), 10);
	});

});