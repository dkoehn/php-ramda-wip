<?php

namespace PHPRambda\Lists {
	use const \PHPRambda\Functions\__;
	use function PHPRambda\Internal\_curry3;
	use function PHPRambda\Internal\_reduce;

	function reduce($fn = __, $acc = __, $list = __)
	{
		return _curry3(function($fn, $acc, $list) {
			return _reduce($fn, $acc, $list);
		}, $fn, $acc, $list);
	}
}
