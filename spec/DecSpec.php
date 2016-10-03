<?php

use function \PHPRambda\Math\dec;

describe('dec', function() {
	it('decrements its argument', function() {
		assertThat(dec(-1), equalTo(-2));
		assertThat(dec(0), equalTo(-1));
		assertThat(dec(1), equalTo(0));
		assertThat(dec(12.34), equalTo(11.34));
	});
});
