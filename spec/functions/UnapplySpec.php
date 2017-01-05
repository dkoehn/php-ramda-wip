<?php

use function PHPRamda\Functions\unapply;
use function PHPRamda\Functions\apply;
use function PHPRamda\Functions\identity;
use function PHPRamda\Internal\_numArgs;

describe('unapply', function() {
	it('returns a function which is always passed one argument', function() {
		$fn = unapply(function() { return count(func_get_args()); });
		eq($fn(), 1);
		eq($fn('x'), 1);
		eq($fn('x', 'y'), 1);
		eq($fn('x', 'y', 'z'), 1);
	});

	it('forwards arguments to decorated function as an array', function() {
		$fn = unapply(function($xs) { return '['.implode(',', $xs).']'; });
		eq($fn(), '[]');
		eq($fn(2), '[2]');
		eq($fn(2, 4), '[2,4]');
		eq($fn(2, 4, 6), '[2,4,6]');
	});

	it('returns a function with length 0', function() {
		pending();
		$fn = unapply(identity());
		eq(_numArgs($fn), 0);
	});

	it('is the inverse of R.apply', function() {
		$rand = function() {
			return floor(200 * rand()) - 100;
		};
		$f = function(...$args) {
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
		$g = unapply(apply($f));
		$n = 1;
		while ($n <= 100) {
			$a = $rand(); $b = $rand(); $c = $rand(); $d = $rand(); $e = $rand();
			eq($f($a, $b, $c, $d, $e), $g($a, $b, $c, $d, $e));
			$n += 1;
		}

		$f = function($xs) { return '['.implode(',', $xs).']'; };
		$g = apply(unapply($f));
		$n = 1;
		while ($n <= 100) {
			$a = $rand(); $b = $rand(); $c = $rand(); $d = $rand(); $e = $rand();
			eq($f([$a, $b, $c, $d, $e]), $g([$a, $b, $c, $d, $e]));
			$n += 1;
		}
	});
});