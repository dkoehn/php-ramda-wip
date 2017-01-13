<?php

use function PHPRamda\Lists\dropWhile;

describe('dropWhile', function() {
	it('skips elements while the function reports `true`', function() {
		eq(dropWhile(function($x) {
			return $x < 5;
		}, [1, 3, 5, 7, 9]), [5, 7, 9]);
	});

	it('returns an empty list for an empty list', function() {
		eq(dropWhile(function() {
			return false;
		}, []), []);
		eq(dropWhile(function() {
			return true;
		}, []), []);
	});

	it('starts at the right arg and acknowledges null', function() {
		$sublist = dropWhile(function($x) {
			return $x !== null;
		}, [1, 3, null, 5, 7]);
		eq(count($sublist), 3);
		eq($sublist[0], null);
		eq($sublist[1], 5);
		eq($sublist[2], 7);
	});

	it('is curried', function() {
		$dropLt7 = dropWhile(function($x) {
			return $x < 7;
		});
		eq($dropLt7([1, 3, 5, 7, 9]), [7, 9]);
		eq($dropLt7([2, 4, 6, 8, 10]), [8, 10]);
	});
});