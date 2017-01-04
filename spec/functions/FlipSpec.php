<?php

use function PHPRamda\Functions\flip;

describe('flip', function() {
	it('returns a function which inverts the first two arguments to the supplied function', function() {
		$f = function($a, $b, $c) { return $a.' '.$b.' '.$c; };
		$g = flip($f);
		eq($f('a', 'b', 'c'), 'a b c');
		eq($g('a', 'b', 'c'), 'b a c');
	});

	it('returns a curried function', function() {
		$f = function($a, $b, $c) { return $a.' '.$b.' '.$c; };
		$g = flip($f);
		$g = $g('a');
		eq($g('b', 'c'), 'b a c');
	});
});