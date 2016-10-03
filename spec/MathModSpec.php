<?php

use function \PHPRambda\Math\mathMod;
use const \PHPRambda\Functions\__;

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
		assertThat(mathMod(-17, 5), equalTo(3));
		assertThat(mathMod(17, 5), equalTo(2));
		assertThat(mathMod(17, 0), equalTo(null));
		// assertThat(mathMod(17.2, 5), equalTo(2));
		// assertThat(mathMod(17, 5.5), equalTo(2));
	});

	it('is curried', function() {
		$f = mathMod(29);
		assertThat($f(6), equalTo(5));
	});


	it('behaves right curried when passed `R.__` for its first argument', function() {
		$mod5 = mathMod(__, 5);
		assertThat($mod5(12), equalTo(2));
		assertThat($mod5(8), equalTo(3));
	});
});
