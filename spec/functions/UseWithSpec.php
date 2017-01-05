<?php

use function PHPRamda\Functions\useWith;

use function PHPRamda\Internal\_numArgs;

describe('useWith', function() {
	$max = function(...$args) {
		$max = null;
		foreach ($args as $n) {
			if ($max === null) {
				$max = $n;
			} elseif ($n > $max) {
				$max = $n;
			}
		}
		return $max;
	};

	$add1 = function($x) {
		return $x + 1;
	};

	$mult2 = function($x) {
		return $x * 2;
	};

	$div3 = function($x) {
		return $x / 3;
	};

	$f = useWith($max, [$add1, $mult2, $div3]);

	it('takes a list of function and returns a function', function() use ($max, $add1, $mult2, $div3) {
		eq(is_callable(useWith($max, [])), true);
		eq(is_callable(useWith($max, [$add1])), true);
		eq(is_callable(useWith($max, [$add1, $mult2, $div3])), true);
	});

	it('passes the arguments received to their respective functions', function() use ($f) {
		eq($f(7, 8, 9), 16); // max(7 + 1, 8 * 2, 9 / 3);
	});

	it('passes additional arguments to the main function', function() use ($f) {
		eq($f(7, 8, 9, 10), 16);
		eq($f(7, 8, 9, 20), 20);
	});

	it('has the correct arity', function() use ($f) {
		eq(_numArgs($f), 3);
	});

	it('passes context to its functions', function() {
		pending();
//		var a = function(x) { return this.f1(x); };
//		var b = function(x) { return this.f2(x); };
//		var c = function(x, y) { return this.f3(x, y); };
//		var d = R.useWith(c, [a, b]);
//		var context = {f1: R.add(1), f2: R.add(2), f3: R.add};
//    eq(a.call(context, 1), 2);
//    eq(b.call(context, 1), 3);
//    eq(d.apply(context, [1, 1]), 5);
//    eq(d.apply(context, [2, 3]), 8);
	});
});