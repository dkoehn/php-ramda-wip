<?php

use function \PHPRamda\Functions\always;

describe('always', function() {
	it('returns a function that returns the object initially supplied', function() {
		$theMeaning = always(42);
		eq($theMeaning(), 42);
		eq($theMeaning(10), 42);
		eq($theMeaning(false), 42);
	});

	it('works with various types', function() {
		$f = always(false);
		eq($f(), false);
		$f = always('abc');
		eq($f(), 'abc');
		$f = always(['a' => 1, 'b' => 2]);
		eq($f(), ['a' => 1, 'b' => 2]);

		$obj = ['a' => 1, 'b' => 2];
		$f = always($obj);
		eq($f(), $obj);

		$now = new \DateTime('1776-07-04');
		$f = always($now);
		eq($f(), $now);

		$f = always(null);
		eq($f(), null);
	});

	it('is curried', function() {
		$f = always();
		$f2 = $f(true);
		eq($f2(), true);
	});
});