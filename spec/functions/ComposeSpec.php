<?php

use function \PHPRamda\Functions\compose;
use function \PHPRamda\Lists\map;
use function \PHPRamda\Math\multiply;
use function \PHPRamda\Internal\_numArgs;

describe('compose', function() {
	it('performs right-to-left function composition', function() {
		$f = compose(map(), multiply(), 'intval');

		eq(_numArgs($f), 2);
		$g = $f('10');
		eq($g([1, 2, 3]), [10, 20, 30]);
		$h = $f('10', 2);
		eq($h([1, 2, 3]), [2, 4, 6]);
	});

	it('throws if given no arguments', function() {
		try {
			compose();
			fail();
		} catch (\Exception $e) {
			eq($e->getMessage(), 'compose requires at least one argument');
		}
	});

	it('can be applied to one argument', function() {
		$f = function($a, $b, $c) {
			return [$a, $b, $c];
		};
		$g = compose($f);
		eq(_numArgs($g), 3);
		eq($g(1, 2, 3), [1, 2, 3]);
	});

	context('compose properties', function() {
		it('composes two functions', function() {
			$f = function($x) {
				return $x + 2;
			};
			$g = function($x) {
				return $x * 2;
			};

			$expected = $f($g(3));

			$h = compose($f, $g);
			eq($h(3), $expected);
		});

		it('is associative', function() {
			$f = function($x) {
				return $x + 2;
			};
			$g = function($x) {
				return $x * 2;
			};
			$h = function($x) {
				return $x / 3;
			};

			$expected = $f($g($h(9)));
			$i = compose($f, $g, $h);
			eq($i(9), $expected);

			$i = compose($f, compose($g, $h));
			eq($i(9), $expected);

			$i = compose(compose($f, $g), $h);
			eq($i(9), $expected);
		});
	});
});
