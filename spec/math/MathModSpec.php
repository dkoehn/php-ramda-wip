<?php

use function \PHPRamda\Math\mathMod;
use const \PHPRamda\Functions\__;

describe('mathMod', function() {
	it('requires integer arguments', function() {
		// assert.notStrictEqual(R.mathMod('s', 3), R.mathMod('s', 3));
		// assert.notStrictEqual(R.mathMod(3, 's'), R.mathMod(3, 's'));
		// assert.notStrictEqual(R.mathMod(12.2, 3), R.mathMod(12.2, 3));
		// assert.notStrictEqual(R.mathMod(3, 12.2), R.mathMod(3, 12.2));
		pending('argument type checking');
	});

	it('behaves differently than PHP modulo', function() {
		assertThat(mathMod(-17, 5), not(equalTo(-17 % 5)));
		assertThat(mathMod(-17.2, 5), not(equalTo(-17.2 % 5)));
		assertThat(mathMod(17, -5), not(equalTo(17 % -5)));
	});

	it('computes the true modulo function', function() {
		eq(mathMod(-17, 5), 3);
		eq(mathMod(17, 5), 2);
		eq(mathMod(17, 0), null);
		// eq(mathMod(17.2, 5), 2);
		// eq(mathMod(17, 5.5), 2);
	});

	it('is curried', function() {
		$f = mathMod(29);
		eq($f(6), 5);
	});


	it('behaves right curried when passed `R.__` for its first argument', function() {
		$mod5 = mathMod(__, 5);
		eq($mod5(12), 2);
		eq($mod5(8), 3);
	});
});
