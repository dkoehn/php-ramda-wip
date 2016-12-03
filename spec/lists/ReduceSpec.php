<?php

use function \PHPRamda\Lists\reduce;

use function \PHPRamda\Math\add;
use function \PHPRamda\Math\multiply;
use function \PHPRamda\Internal\_numArgs;

describe('reduce', function() {
	it('folds simple functions over arrays with the supplied accumulator', function() {
		eq(reduce(add(), 0, [1, 2, 3, 4]), 10);
		eq(reduce(multiply(), 1, [1, 2, 3, 4]), 24);
	});

	it('dispatches to objects that implement `reduce`', function() {
		$obj = new ReduceTestObject;
		$obj->x = [1, 2, 3];
		eq(reduce(add(), 0, $obj), 'override');
		eq(reduce(add(), 10, $obj), 'override');
	});

	it('returns the accumulator for an empty array', function() {
		eq(reduce(add(), 0, []), 0);
		eq(reduce(multiply(), 1, []), 1);
		//eq(reduce(concat(), [], []), []);
	});

	it('is curried', function() {
		$addOrConcat = reduce(add());
		$sum = $addOrConcat(0);
		eq($sum([1, 2, 3, 4]), 10);
	});

	it('correctly reports the arity of curried versions', function() {
		$sum = reduce(add(), 0);
		eq(_numArgs($sum), 1);
	});
});

class ReduceTestObject
{
	public $x;

	public function reduce()
	{
		return 'override';
	}
}
