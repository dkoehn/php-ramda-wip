<?php

use function PHPRamda\Functions\nthArg;

use function PHPRamda\Internal\_numArgs;

describe('nthArg', function() {
	it('returns a function which returns its nth argument', function() {
		$n = nthArg(0);
		eq($n('foo', 'bar'), 'foo');
		$n1 = nthArg(1);
		eq($n1('foo', 'bar'), 'bar');
  });

	it('accepts negative offsets', function() {
		$n1 = nthArg(-1);
		eq($n1('foo', 'bar'), 'bar');
		$n2 = nthArg(-2);
		eq($n2('foo', 'bar'), 'foo');
		$n3 = nthArg(-3);
		eq($n3('foo', 'bar'), null);
  });

	it('returns a function with length n + 1 when n >= 0', function() {
		eq(_numArgs(nthArg(0)), 1);
		eq(_numArgs(nthArg(1)), 2);
		eq(_numArgs(nthArg(2)), 3);
		eq(_numArgs(nthArg(3)), 4);
	});

	it('returns a function with length 1 when n < 0', function() {
		eq(_numArgs(nthArg(-1)), 1);
		eq(_numArgs(nthArg(-2)), 1);
		eq(_numArgs(nthArg(-3)), 1);
	});

	it('returns a curried function', function() {
		$n1 = nthArg(1);
		$n1foo = $n1('foo');
		eq($n1('foo', 'bar'), $n1foo('bar'));
		$n2 = nthArg(2);
		$n2foo = $n2('foo');
		$n2foobar = $n2foo('bar');
		eq($n2('foo', 'bar', 'baz'), $n2foobar('baz'));
	});
});