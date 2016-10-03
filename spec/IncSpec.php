<?php

use function \PHPRambda\Math\inc;

describe('inc', function() {
	it('increments its argument', function() {
		assertThat(inc(-1), equalTo(0));
		assertThat(inc(0), equalTo(1));
		assertThat(inc(1), equalTo(2));
		assertThat(inc(12.34), equalTo(13.34));
	});
});
