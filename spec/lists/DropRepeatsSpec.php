<?php

use function PHPRamda\Lists\dropRepeats;

describe('dropRepeats', function() {
	$objs = [1, 2, 3, 4, 5, 3, 2];
	$objs2 = [1, 2, 2, 2, 3, 4, 4, 5, 5, 3, 2, 2];

	it('removes repeated elements', function() use ($objs, $objs2) {
		eq(dropRepeats($objs2), $objs);
		eq(dropRepeats($objs), $objs);
	});

	it('returns an empty array for an empty array', function() {
		eq(dropRepeats([]), []);
	});

	it('can act as a transducer', function() {
		pending();
//		eq(R.into([], R.dropRepeats, objs2), objs);
	});

	it('has R.equals semantics', function() {
		pending();
//		function Just(x) { this.value = x; }
//		Just.prototype.equals = function(x) {
//			return x instanceof Just && R.equals(x.value, this.value);
//		};
//
//		eq(R.dropRepeats([0, -0]).length, 2);
//		eq(R.dropRepeats([-0, 0]).length, 2);
//		eq(R.dropRepeats([NaN, NaN]).length, 1);
//		eq(R.dropRepeats([new Just([42]), new Just([42])]).length, 1);
	});

});