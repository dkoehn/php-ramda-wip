<?php

use function \PHPRamda\Math\mean;
use const \PHPRamda\Functions\__;

describe('mean', function() {
	it('returns mean of a nonemtpy list', function() {
		assertThat(mean([2]), equalTo(2));
		assertThat(mean([2, 7]), equalTo(4.5));
		assertThat(mean([2, 7, 9]), equalTo(6));
		assertThat(mean([2, 7, 9, 10]), equalTo(7));
	});

	it('returns null for an empty list', function() {
		assertThat(mean([]), identicalTo(null));
	});
});
