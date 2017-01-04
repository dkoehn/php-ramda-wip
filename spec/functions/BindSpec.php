<?php

use function PHPRamda\Functions\bind;
use function PHPRamda\Internal\_numArgs;

describe('bind', function() {
	class Foo
	{
		public $x;

		public function __construct($x)
		{
			$this->x = $x;
		}
	}

	$add = function($x) {
		return $this->x + $x;
	};

	it('returns a callable', function() use ($add) {
		$foo = new Foo(2);
		eq(is_callable(bind($add, $foo)), true);
	});

	it('returns a function bound to the specified context object', function() use ($add) {
		$f = new Foo(2);
		$isFoo = function() {
			return $this instanceof Foo;
		};
		$isFooBound = bind($isFoo, $f);
		eq($isFoo(), false);
		eq($isFooBound(), true);
	});

	it('is curried', function() use ($add) {
		$f = new Foo(1);
		$add = bind($add);
		$add = $add($f);
		eq($add(10), 11);
	});

	it('preserves arity', function() {
		$f0 = function() { return 0; };
		$f1 = function($a) { return $a; };
		$f2 = function($a, $b) { return $a + $b; };
		$f3 = function($a, $b, $c) { return $a + $b + $c; };

		eq(_numArgs(bind($f0, new \stdClass())), 0);
		eq(_numArgs(bind($f1, new \stdClass())), 1);
		eq(_numArgs(bind($f2, new \stdClass())), 2);
		eq(_numArgs(bind($f3, new \stdClass())), 3);
	});
});
