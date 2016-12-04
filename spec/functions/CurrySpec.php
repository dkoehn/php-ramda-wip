<?php

use const \PHPRamda\Functions\__;
use function \PHPRamda\Functions\curry;
use function \PHPRamda\Internal\_numArgs;

describe('curry', function() {
	it('curries a single value', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12);

		eq($g(3, 6, 2), 15);
	});

	it('curries multiple values', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12, 3);
		eq($g(6, 2), 15);

		$h = $f(12, 3, 6);
		eq($h(2), 15);
	});

	it('allows further currying of a curried function', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12);
		eq($g(3, 6, 2), 15);

		$h = $g(3);
		eq($h(6, 2), 15);
	});

	it('properly reports the length of the curried function', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });
		eq(_numArgs($f), 4);

		$g = $f(12);
		eq(_numArgs($g), 3);

		$h = $g(3);
		eq(_numArgs($h), 2);

		eq(_numArgs($g(3, 6)), 1);
	});

	// it('preserves context', function() {
	// 	$ctx = new \stdClass;
	// 	$ctx->x = 10;
	//
	// 	$f = function($a, $b) { return $a + $b * $this->x; };
	// 	$g = curry($f);
	//
	// 	$g->bindTo($ctx);
	//
	// 	pending('can we bind $this?');
	// 	//assertThat(42, equalTo($g(2, 4)));
	// });

	it('supports placeholder', function() {
		$f = function($a, $b, $c) { return [$a, $b, $c]; };

		$g = curry($f);

		$g1 = $g(1);
		$g2 = $g1(2);
		$g3 = $g(1,2);
		eq($g2(3), [1, 2, 3]);
		eq($g1(2, 3), [1, 2, 3]);
		eq($g3(3), [1, 2, 3]);
		eq($g(1, 2, 3), [1, 2, 3]);

		$gPartial1 = $g(__, 2, 3);
		$gPartial2 = $g(1, __, 3);
		$gPartial3 = $g(1, 2, __);
		eq($gPartial1(1), [1, 2, 3]);
		eq($gPartial2(2), [1, 2, 3]);
		eq($gPartial3(3), [1, 2, 3]);

		$gPartial23 = $g(1, __, __);
		$gPartial13 = $g(__, 2, __);
		$gPartial12 = $g(__, __, 3);
		eq($gPartial23(2, 3), [1, 2, 3]);
		eq($gPartial13(1, 3), [1, 2, 3]);
		eq($gPartial12(1, 2), [1, 2, 3]);
	});

	it('forwards extra arguments', function() {
		$f = function($a, $b, $c) {
			return array_slice(func_get_args(), 0);
		};

		$g = curry($f);
		eq($g(1, 2, 3), [1, 2, 3]);
		eq($g(1, 2, 3, 4), [1, 2, 3, 4]);

		$h = $g(1,2);
		eq($h(3, 4), [1, 2, 3, 4]);

		$h = $g(1);
		eq($h(2, 3, 4), [1, 2, 3, 4]);

		$h1 = $h(2);
		eq($h1(3, 4), [1, 2, 3, 4]);
	});
});
