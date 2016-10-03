<?php

namespace PHPRambda\Functions {
	use function \PHPRambda\Internal\_arity;
	use function \PHPRambda\Internal\_curry1;
	use function \PHPRambda\Internal\_curryN;
	use function \PHPRambda\Internal\_numArgs;

	const __ = '__PLACHOLDER__';

	function curry(callable $fn, ...$params)
	{
		return _curry1(function($fn) {
			return curryN(_numArgs($fn), $fn);
		}, $fn, ...$params);
	}

	function curryN($arity, callable $fn, ...$params)
	{
		if ($arity === 1) {
			return _curry1($fn);
		}

		return _arity($arity, _curryN($arity, $params, $fn));
	}
}
