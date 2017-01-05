<?php

use function PHPRamda\Functions\wrap;

describe('wrap', function() {
	it('wraps a function inside another function', function() {
		$toUpper = function($gr, $name) { return strtoupper($gr($name)); };
		$greet = function($name) { return 'Hello '.$name; };

		$shouldGreet = wrap($greet, $toUpper);
		eq($shouldGreet('Kathy'), 'HELLO KATHY');
	});
});