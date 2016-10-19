<?php

use function \PHPRamda\Math\sum;

describe('sum', function() {
	it('adds together the array of numbers supplied', function() {
		assertThat(sum([1, 2, 3, 4]), equalTo(10));
	});

	it('does not save the state of the accumulator', function() {
		assertThat(sum([1, 2, 3, 4]), equalTo(10));
		assertThat(sum([1]), equalTo(1));
		assertThat(sum([5, 5, 5, 5, 5]), equalTo(25));
	});
});
