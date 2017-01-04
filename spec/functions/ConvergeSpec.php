<?php

use function PHPRamda\Functions\converge;
use function PHPRamda\Functions\bind;
use function PHPRamda\Internal\_numArgs;
use function PHPRamda\Math\add;

describe('converge', function() {
	$mult = function($a, $b) {
		return $a * $b;
	};
	$f1 = converge($mult, [function($a) {
		return $a;
	}, function($a) {
		return $a;
	}]);
	$f2 = converge($mult, [function($a) {
		return $a;
	}, function($a, $b) {
		return $b;
	}]);
	$f3 = converge($mult, [function($a) {
		return $a;
	}, function($a, $b, $c) {
		return $c;
	}]);

	it('passes the results of applying the arguments individually to two separate functions into a single one', function() use ($mult) {
		$f = converge($mult, [add(1), add(3)]);
		eq($f(2), 15); // mult(add1(2), add3(2)) = mult(3, 5) = 3 * 15;
	});

	it('returns a function with the length of the "longest" argument', function() use ($f1, $f2, $f3) {
		eq(_numArgs($f1), 1);
		eq(_numArgs($f2), 2);
		eq(_numArgs($f3), 3);
	});

	it('passes context to its functions');
	//, function() {
//		class ConvergeContext {
//			public function f1($x) {
//				return add(1, $x);
//			}
//			public function f2($x) {
//				return add(2, $x);
//			}
//			public function f3($x) {
//				return add(3, $x);
//			}
//		}
//		$context = new ConvergeContext();
//		$a = function($x) { return $this->f1($x); };
//		$b = function($x) { return $this->f2($x); };
//		$c = function($x) { return $this->f3($x); };
//		$d = converge($c, [$a, $b]);
//
//		$a = bind($a, $context);
//		$b = bind($b, $context);
//		$d = bind($d, $context);
//		eq($a(1), 2);
//		eq($b(1), 3);
//		eq($d(1), 5);
//	});

	it('returns a curried function', function() use ($f2) {
		$f26 = $f2(6);
		eq($f26(7), 42);
	});

	it('works with empty functions list', function() {
		$fn = converge(function() { return count(func_get_args()); }, []);
		eq(_numArgs($fn), 0);
		eq($fn(), 0);
	});
});