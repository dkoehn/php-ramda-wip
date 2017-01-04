<?php

namespace PHPRamda\Relation {
	use function \PHPRamda\Internal\_curry2;
	use const \PHPRamda\Functions\__;

	function min($a = __, $b = __) {
		return _curry2(function($a, $b) {
			return $b < $a
				? $b
				: $a;
		}, $a, $b);
	}

	function max($a = __, $b = __) {
		return _curry2(function($a, $b) {
			return $b > $a
				? $b
				: $a;
		}, $a, $b);
	}
}