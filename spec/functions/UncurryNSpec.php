<?php

use function PHPRamda\Functions\uncurryN;

use function PHPRamda\Internal\_numArgs;
use function PHPRamda\Math\add;

use const PHPRamda\Functions\__;

describe('uncurryN', function() {
	$a2 = function($a) {
		return function($b) use ($a) {
			return $a + $b;
		};
	};

	$a3 = function($a) {
		return function($b) use ($a) {
			return function($c) use ($a, $b) {
				return $a + $b + $c;
			};
		};
	};

	$a3b = function($a) {
		return function($b) use ($a) {
			return function($c) use ($a, $b) {
				$args = func_get_args();
				return $a + $b + $c + (isset($args[1]) ? $args[1] : 0) + (isset($args[2]) ? $args[2] : 0);
			};
		};
	};

	$a4 = function($a) {
		return function($b) use ($a) {
			return function($c) use ($a, $b) {
				return function($d) use ($a, $b, $c) {
					return $a + $b + $c + $d;
				};
			};
		};
	};

	it('accepts an arity', function() use ($a3) {
		$uncurried = uncurryN(3, $a3);
		eq($uncurried(1, 2, 3), 6);
	});

	it('returns a function of the specified arity', function() use ($a2, $a3, $a4) {
		eq(_numArgs(uncurryN(2, $a2)), 2);
		eq(_numArgs(uncurryN(3, $a3)), 3);
		eq(_numArgs(uncurryN(4, $a4)), 4);
	});

	it('forwards extra arguments', function() use ($a3b) {
		$g = uncurryN(3, $a3b);
		eq($g(1, 2, 3), 6);
		eq($g(1, 2, 3, 4), 10);
		eq($g(1, 2, 3, 4, 5), 15);
	});

	it('works with ordinary uncurried functions', function() {
		$z2 = uncurryN(2, function($a, $b) { return $a + $b; });
		$z3 = uncurryN(3, function($a, $b, $c) { return $a + $b + $c; });
		eq($z2(10, 20), 30);
		eq($z3(10, 20, 30), 60);
  });

	it('works with ramda-curried functions', function() {
		$add = uncurryN(2, add());
		eq($add(10, 20), 30);
  });

	it('returns a function that supports R.__ placeholder', function() use ($a3) {
		$g = uncurryN(3, $a3);
		$g1 = $g(1);
		$g12 = $g1(2);
		eq($g12(3), 6);
		eq($g1(2, 3), 6);

		$g12 = $g(1, 2);
		eq($g12(3), 6);
		eq($g(1, 2, 3), 6);

		$g23 = $g(__, 2, 3);
		eq($g23(1), 6);
		$g13 = $g(1, __, 3);
		eq($g13(2), 6);
		$g12 = $g(1, 2, __);
		eq($g12(3), 6);

		$gP = $g(__, __, __);
		$gP2 = $gP(__, __);
		$gP = $gP2(__);
		eq($gP(1, 2, 3), 6);
  });
});