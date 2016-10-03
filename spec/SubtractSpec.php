<?php

use function \PHPRambda\Math\subtract;
use const \PHPRambda\Functions\__;

describe('subtract', function() {
	it('subtracts two numbers', function() {
		assertThat(subtract(22, 7), equalTo(15));
	});

	it('coerces its arguments to numbers', function() {
		assertThat(subtract('1', '2'), equalTo(-1));
		assertThat(subtract(1, '2'), equalTo(-1));
		assertThat(subtract(true, false), equalTo(1));
		assertThat(subtract(null, null), equalTo(0));
	});

	it('is curried', function() {
		$ninesCompl = subtract(9);
		assertThat($ninesCompl(6), equalTo(3));
	});

	it('behaves right curried when passed `R.__` for its first argument', function() {
		$minus5 = subtract(__, 5);
		assertThat($minus5(17), equalTo(12));
	});
});
