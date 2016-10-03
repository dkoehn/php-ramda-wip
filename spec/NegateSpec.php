<?php

use function \PHPRambda\Math\negate;

describe('negate', function() {
	it('negates its argument', function() {
		assertThat(negate(-1), equalTo(1));
		assertThat(negate(0), equalTo(0));
		assertThat(negate(1), equalTo(-1));
	});
});
