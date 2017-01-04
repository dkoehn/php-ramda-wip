<?php

use function PHPRamda\Functions\memoize;

use function PHPRamda\Internal\_numArgs;

describe('memoize', function() {
	it('calculates the value for a given input only once', function() {
		$ctr = 0;
		$fib = memoize(function($n) use (&$ctr, &$fib) { $ctr += 1; return $n < 2 ? $n : $fib($n - 2) + $fib($n - 1); });
		$result = $fib(10);
		eq($result, 55);
		eq($ctr, 11); // fib(0), fib(1), ... fib(10), no memoization would take 177 iterations.
	});

	it('handles multiple parameters', function() {
		$f = memoize(function($a, $b, $c) { return $a.', '.$b.$c; });
		eq($f('Hello', 'World' , '!'), 'Hello, World!');
		eq($f('Goodbye', 'Cruel World' , '!!!'), 'Goodbye, Cruel World!!!');
		eq($f('Hello', 'how are you' , '?'), 'Hello, how are you?');
		eq($f('Hello', 'World' , '!'), 'Hello, World!');
	});

	it('does not rely on reported arity', function() {
		$identity = memoize(function() { $args = func_get_args(); return $args[0]; });
		eq($identity('x'), 'x');
		eq($identity('y'), 'y');
	});

	it('memoizes "false" return values', function() {
		$count = 0;
		$inc = memoize(function($n) use (&$count) {
				$count += 1;
				return $n + 1;
			});
		eq($inc(-1), 0);
		eq($inc(-1), 0);
		eq($inc(-1), 0);
		eq($count, 1);
	});

	it('can be applied to nullary function', function() {
		$count = 0;
		$f = memoize(function() use (&$count) {
				$count += 1;
				return 42;
			});
		eq($f(), 42);
		eq($f(), 42);
		eq($f(), 42);
		eq($count, 1);
	});

	it('can be applied to function with optional arguments', function() {
		pending();
		$count = 0;
		$f = memoize(function($a = null, $b = null) use (&$count) {
				$count += 1;
				$args = func_get_args();
				switch (count($args)) {
					case 0: $a = 'foo';
					case 1: $b = 'bar';
				}
				return $a . $b;
			});
		eq($f(), 'foobar');
		eq($f(), 'foobar');
		eq($f(), 'foobar');
		eq($count, 1);
	});

	it('differentiates values with same string representation', function() {
		$f = memoize(function($x) { return ''.$x; });
		eq($f(42), '42');
		eq($f('42'), '42');
	});

	it('retains arity', function() {
		$f = memoize(function($a, $b) { return $a + $b; });
		eq(_numArgs($f), 2);
	});
});