<?php

use function PHPRamda\Lists\chain;
use function PHPRamda\Internal\_numArgs;

describe('chain', function() {
//	$intoArray = into([]);
	$add1 = function($x) { return [$x + 1]; };
	$dec = function($x) { return [$x - 1]; };
	$times2 = function($x) { return [$x * 2]; };

	it('maps a function over a nested list and returns the (shallow) flattened result', function() use ($times2) {
		eq(chain($times2, [1, 2, 3, 1, 0, 10, -3, 5, 7]), [2, 4, 6, 2, 0, 20, -6, 10, 14]);
		eq(chain($times2, [1, 2, 3]), [2, 4, 6]);
	});

	it('does not flatten recursively', function() {
		$f = function($xs) {
			return isset($xs[0]) ? [$xs[0]] : [];
		};
		eq(chain($f, [[1], [[2], 100], [], [3, [4]]]), [1, [2], 3]);
	});

	it('maps a function (a -> [b]) into a (shallow) flat result', function() {
		pending();
//		eq(intoArray(R.chain(times2), [1, 2, 3, 4]), [2, 4, 6, 8]);
	});

	it('interprets ((->) r) as a monad', function() {
		$h = function($r) { return $r * 2; };
		$f = function($a) {
			return function($r) use ($a) {
				return $r + $a;
			};
		};
		$bound = chain($f, $h);
		eq($bound(10), (10 * 2) + 10);
  });

	it('dispatches to objects that implement `chain`', function() {
		pending();
//		var obj = {x: 100, chain: function(f) { return f(this.x); }};
//    eq(R.chain(add1, obj), [101]);
  });

	it('dispatches to transformer objects', function() {
		pending();
//		eq(_isTransformer(R.chain(add1, listXf)), true);
	});

	it('composes', function() use ($times2, $dec) {
		$mdouble = chain($times2);
		$mdec = chain($dec);
		eq($mdec($mdouble([10, 20, 30])), [19, 39, 59]);
	});

	it('can compose transducer-style', function() {
		pending();
//		var mdouble = R.chain(times2);
//		var mdec = R.chain(dec);
//		var xcomp = R.compose(mdec, mdouble);
//		eq(intoArray(xcomp, [10, 20, 30]), [18, 38, 58]);
	});

	it('is curried', function() use ($add1) {
		$flatInc = chain($add1);
		eq($flatInc([1, 2, 3, 4, 5, 6]), [2, 3, 4, 5, 6, 7]);
	});

	it('correctly reports the arity of curried versions', function() use ($add1) {
		$inc = chain($add1);
		eq(_numArgs($inc), 1);
	});
});