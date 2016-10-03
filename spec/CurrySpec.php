<?php

use const \PHPRambda\Functions\__;
use function \PHPRambda\Functions\curry;
use function \PHPRambda\Internal\_numArgs;

describe('curry', function() {
	it('curries a single value', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12);

		assertThat(15, equalTo($g(3, 6, 2)));
	});
	it('curries multiple values', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12, 3);
		assertThat(15, equalTo($g(6, 2)));

		$h = $f(12, 3, 6);
		assertThat(15, equalTo($h(2)));
	});
	it('allows further currying of a curried function', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });

		$g = $f(12);
		assertThat(15, equalTo($g(3, 6, 2)));

		$h = $g(3);
		assertThat(15, equalTo($h(6, 2)));
	});
	it('properly reports the length of the curried function', function() {
		$f = curry(function($a, $b, $c, $d) { return ($a + $b * $c) / $d; });
		assertThat(4, equalTo(_numArgs($f)));

		$g = $f(12);
		assertThat(3, equalTo(_numArgs($g)));

		$h = $g(3);
		assertThat(2, equalTo(_numArgs($h)));

		assertThat(1, equalTo(_numArgs($g(3, 6))));
	});
	it('preserves context', function() {
		$ctx = new \stdClass;
		$ctx->x = 10;

		$f = function($a, $b) { return $a + $b * $this->x; };
		$g = curry($f);

		$g->bindTo($ctx);

		pending('can we bind $this?');
		//assertThat(42, equalTo($g(2, 4)));
	});
	it('supports placeholder', function() {
		$f = function($a, $b, $c) { return [$a, $b, $c]; };

		$g = curry($f);

		$g1 = $g(1);
		$g2 = $g1(2);
		$g3 = $g(1,2);
		assertThat([1,2,3], identicalTo($g2(3)));
		assertThat([1,2,3], identicalTo($g1(2,3)));
		assertThat([1,2,3], identicalTo($g3(3)));
		assertThat([1,2,3], identicalTo($g(1,2,3)));

		$gPartial1 = $g(__, 2, 3);
		$gPartial2 = $g(1, __, 3);
		$gPartial3 = $g(1, 2, __);
		assertThat([1,2,3], identicalTo($gPartial1(1)));
		assertThat([1,2,3], identicalTo($gPartial2(2)));
		assertThat([1,2,3], identicalTo($gPartial3(3)));

		$gPartial23 = $g(1, __, __);
		$gPartial13 = $g(__, 2, __);
		$gPartial12 = $g(__, __, 3);
		assertThat([1,2,3], identicalTo($gPartial23(2, 3)));
		assertThat([1,2,3], identicalTo($gPartial13(1, 3)));
		assertThat([1,2,3], identicalTo($gPartial12(1, 2)));
	});

	it('forwards extra arguments', function() {
		$f = function($a, $b, $c) {
			return array_slice(func_get_args(), 0);
		};

		$g = curry($f);
		assertThat([1,2,3], identicalTo($g(1, 2, 3)));
		assertThat([1,2,3, 4], identicalTo($g(1, 2, 3, 4)));
		$h = $g(1,2);
		assertThat([1,2,3,4], identicalTo($h(3, 4)));
		$h = $g(1);
		assertThat([1,2,3,4], identicalTo($h(2, 3, 4)));
		$h1 = $h(2);
		assertThat([1,2,3,4], identicalTo($h1(3, 4)));
	});
});
