<?php

use function \PHPRamda\Math\product;

describe('product', function() {
	it('multiplies together the array of numbers supplied', function() {
		eq(product([1, 2, 3, 4]), 24);
	});
});
