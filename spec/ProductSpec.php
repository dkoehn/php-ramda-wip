<?php

use function \PHPRambda\Math\product;

describe('product', function() {
	it('multiplies together the array of numbers supplied', function() {
		assertThat(product([1, 2, 3, 4]), equalTo(24));
	});
});
