<?php

use function PHPRamda\Lists\dropLastWhile;

describe('dropLastWhile', function() {
	it('skips elements while the function reports `true`', function() {
		eq(dropLastWhile(function($x) {
			return $x >= 5;
		}, [1, 3, 5, 7, 9]), [1, 3]);
	});

	it('returns an empty list for an empty list', function() {
		eq(dropLastWhile(function() {
			return false;
		}, []), []);
		eq(dropLastWhile(function() {
			return true;
		}, []), []);
	});

	it('starts at the right arg and acknowledges null', function() {
		$sublist = dropLastWhile(function($x) {
			return $x !== null;
		}, [1, 3, null, 5, 7]);
		eq(count($sublist), 3);
		eq($sublist[0], 1);
		eq($sublist[1], 3);
		eq($sublist[2], null);
  });

	it('is curried', function() {
		$dropGt7 = dropLastWhile(function($x) {
			return $x > 7;
		});
		eq($dropGt7([1, 3, 5, 7, 9]), [1, 3, 5, 7]);
		eq($dropGt7([1, 3, 5]), [1, 3, 5]);
	});

	it('can act as a transducer', function() {
		pending();
//		$dropLt7 = dropLastWhile(function($x) {return $x < 7;});
//		eq(R.into([], dropLt7, [1, 3, 5, 7, 9, 1, 2]), [1, 3, 5, 7, 9]);
//		eq(R.into([], dropLt7, [1, 3, 5]), []);
	});

});