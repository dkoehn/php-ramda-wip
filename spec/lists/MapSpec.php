<?php

use function \PHPRamda\Lists\map;
use function \PHPRamda\Math\add;
use function \PHPRamda\Math\multiply;
use function \PHPRamda\Math\dec;
use function \PHPRamda\Internal\_numArgs;

describe('map', function() {
	it('maps simple functions over arrays', function() {
		$times2 = multiply(2);
		eq(map($times2, [1, 2, 3, 4]), [2, 4, 6, 8]);
	});

	it('maps simple functions over hashes', function() {
		eq(map(dec(), []), []);
		eq(map(dec(), ['x' => 4, 'y' => 5, 'z' => 6]), ['x' => 3, 'y' => 4, 'z' => 5]);
	});

	it('interprets ((->) r) as a functor', function() {
		$f = function($a) {
			return $a - 1;
		};
		$g = function($b) {
			return $b * 2;
		};
		$h = map($f, $g);
		eq($h(10), (10 * 2) - 1);
	});

	it('dispatches to objects that implement `map`', function() {
		$obj = new MapTestObject;
		$obj->x = 100;
		eq(map(add(1), $obj), 101);
	});

	it('composes', function() {
		$mdouble = map(multiply(2));
		$mdec = map(dec());
		eq($mdec($mdouble([10, 20, 30])), [19, 39, 59]);
	});

	it('is curried', function() {
		$inc = map(add(1));
		eq($inc([1, 2, 3]), [2, 3, 4]);
	});

	it('correctly reports the arity of curried versions', function() {
		$inc = map(add(1));
		eq(_numArgs($inc), 1);
	});
});

class MapTestObject
{
	public $x;

	public function map($fn)
	{
		return $fn($this->x);
	}
}
