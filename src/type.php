<?php

namespace PHPRambda\Type {
	use const \PHPRambda\Functions\_;
	use function \PHPRambda\Internal\_curry1;
	use function \PHPRambda\Internal\_curry2;

	const _Object = 'Object';
	const _Number = 'Number';
	const _String = 'String';
	const _Null = 'Null';
	const _Array = 'Array';
	const _Boolean = 'Boolean';

	function is($type = _, $x = _)
	{
		return _curry2(function($type, $x) {
			switch ($type) {
				case _Object:
					return is_object($x) || is_array($x);
				case _Array:
					return isArrayLike($x);
				case _String:
					return is_string($x);
				case _Number:
					return is_numeric($x);
				case _Null:
					return $x === null;
				case _Boolean:
					return $x === true || $x === false;
				default:
					return is_subclass_of($x, $type);
			}
		}, $type, $x);
	}

	function isArrayLike($x = _)
	{
		return _curry1(function($x) {
			return $x instanceOf \Generator || is_array($x);
		}, $x);
	}

	function isNil($x = _)
	{
		return _curry1(function($x) {
			return $x === null;
		});
	}

	// TODO: prop?
	// function propIs()
	// {
	//
	// }

	function type($x = _)
	{
		return _curry1(function($x) {
			if ($x === null) {
				return _Null;
			} elseif (is_object($x)) {
				return _Object;
			} elseif (is_string($x)) {
				return _String;
			} elseif (is_numeric($x)) {
				return _Number;
			} elseif (isArrayLike($x)) {
				return _Array;
			} elseif ($x === true || $x === false) {
				return _Boolean;
			}

			return _Object;
		}, $x);
	}
}
