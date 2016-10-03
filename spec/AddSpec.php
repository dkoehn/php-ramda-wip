<?php

use function \PHPRambda\Math\add;

describe('add', function() {
	it('adds together two numbers', function() {
		assertThat(10, equalTo(add(3, 7)));
	});

	it('coerces its arguments to numbers', function() {
		assertThat(add('1', '2'), equalTo(3));
		assertThat(add(1, '2'), equalTo(3));
		assertThat(add(true, false), equalTo(1));
		assertThat(add(null, null), equalTo(0));
	});
	it('is curried', function() {
		$incr = add(1);
		assertThat($incr(42), equalTo(43));
	});
});
