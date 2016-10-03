<?php

use function \PHPRambda\Math\median;
use const \PHPRambda\Functions\__;

describe('median', function() {
	it('returns middle value of an odd-length list', function() {
		assertThat(median([2]), equalTo(2));
		assertThat(median([2, 9, 7]), equalTo(7));
	});

	it('returns mean of two middle values of a nonempty even-length list', function() {
		assertThat(median([7, 2]), equalTo(4.5));
		assertThat(median([7, 2, 10, 9]), equalTo(8));
	});

	it('returns null for an empty list', function() {
		assertThat(median([]), identicalTo(null));
	});
});
