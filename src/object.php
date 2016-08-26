<?php

namespace PHPRambda\Objects {

	use const PHPRambda\Functions\_;
	use function PHPRambda\Internal\_curry1;
	use function PHPRambda\Internal\_curry2;
	use function PHPRambda\Internal\_curry3;
	use function PHPRambda\Internal\_slice;
	use function \PHPRambda\Relation\equals;

	function assoc($prop = _, $val = _, $obj = _)
	{
		return _curry3(function($prop, $val, $obj) {
			if (is_object($obj)) {
				$result = clone $obj;
			} else {
				$result = $obj;
			}
			$result[$prop] = $val;
			return $result;
		}, $prop, $val, $obj);
	}

	function assocPath($path = _, $val = _, $obj = _)
	{
		return _curry3(function($path, $val, $obj) {
			switch (count($path)) {
				case 0:
					return $val;
				case 1:
					return assoc($path[0], $val, $obj);
				default:
					return assoc($path[0], assocPath(_slice($path, 1), $val, prop($path[0], $obj)), $obj);
			}
		}, $path, $val, $obj);
	}

	//TODO:
//	function clone()
//	{
//
//	}

	function dissoc($prop = _, $obj = _)
	{
		return _curry2(function($prop, $obj) {
			if (is_object($obj)) {
				$result = clone $obj;
			} else {
				$result = $obj;
			}
			unset($result[$prop]);
			return $result;
		}, $prop, $obj);
	}

	function dissocPath($path = _, $obj = _)
	{
		return _curry2(function($path, $obj) {
			switch (count($path)) {
				case 0:
					return $obj;
				case 1:
					return dissoc($path[0], $obj);
				default:
					$head = $path[0];
					$tail = _slice($path, 1);
					return !isset($obj[$head]) ? $obj : assoc($head, dissocPath($tail, prop($head, $obj)), $obj);
			}
		}, $path, $obj);
	}

	function eqProps($prop = _, $obj1 = _, $obj2 = _)
	{
		return _curry3(function($prop, $obj1, $obj2) {
			return equals(prop($prop, $obj1), prop($prop, $obj2));
		}, $prop, $obj1, $obj2);
	}

	function evolve($transformations = _, $obj = _)
	{
		return _curry2(function($transformations, $obj) {
			if (is_object($obj)) {
				$result = new \stdClass();
			} else {
				$result = [];
			}

			foreach ($obj as $k => $v) {
				if (array_key_exists($k, $transformations)) {
					if (is_callable($transformations[$k])) {
						$result[$k] = $transformations[$k]($v);
					} else {
						$result[$k] = evolve($transformations[$k], $v);
					}
				}
			}

			return $result;
		}, $transformations, $obj);
	}

	function has($prop = _, $obj = _)
	{
		return _curry2(function($prop, $obj) {
			if (is_array($obj)) {
				return array_key_exists($prop, $obj);
			}

			return property_exists($obj, $prop);
		}, $prop, $obj);
	}

	//TODO:
//	function hasIn()
//	{
//
//	}

	function invert($obj = _)
	{
		return _curry1(function($obj) {
			$props = array_keys((array)$obj);
			$len = count($props);
			$idx = 0;
			if (is_object($obj)) {
				$out = new \stdClass();
			} else {
				$out = [];
			}

			while ($idx < $len) {
				$key = $props[$idx];
				if (array_key_exists($obj[$key], $out)) {
					if (!is_array($out[$obj[$key]])) {
						$out[$obj[$key]] = [$out[$obj[$key]]];
					}
					$out[$obj[$key]][] = $key;
				} else {
					$out[$obj[$key]] = $key;
				}
				$idx += 1;
			}
			return $out;
		}, $obj);
	}

	function invertObj($obj = _)
	{
		return _curry1(function($obj) {
			$props = array_keys((array)$obj);
			$len = count($props);
			$idx = 0;
			if (is_object($obj)) {
				$out = new \stdClass();
			} else {
				$out = [];
			}

			while ($idx < $len) {
				$key = $props[$idx];
				$out[$obj[$key]] = $key;
				$idx += 1;
			}
			return $out;
		}, $obj);
	}

	function keys($obj = _)
	{
		return _curry1(function($obj) {
			return array_keys((array)$obj);
		}, $obj);
	}

	//TODO:
//	function keysIn()
//	{
//
//	}

	//TODO:
//	function lens() {}
//	function lensIndex() {}
//	function lensPath() {}
//	function lensProp() {}

	function mapObjIndexed($fn = _, $obj = _)
	{
		return _curry2(function($fn, $obj) {
			return \PHPRambda\Internal\_reduce(function($acc, $key) use ($fn, $obj) {
				$acc[$key] = $fn(prop($key, $obj), $key, $obj);
				return $acc;
			}, new \stdClass(), keys($obj));
		}, $fn, $obj);
	}

	function merge($obj1 = _, $obj2 = _)
	{
		return _curry2(function($obj1, $obj2) {
			//TODO:
		}, $obj1, $obj2);
	}

	function path($paths = _, $obj = _)
	{
		return _curry2(function($paths, $obj) {
			$val = $obj;
			$idx = 0;
			while ($idx < count($paths)) {
				if ($val === null) {
					return null;
				}

				$val = prop($paths[$idx], $val);
				$idx += 1;
			}

			return $val;
		}, $paths, $obj);
	}

	function prop($p = _, $obj = _)
	{
		return propOr(null, $p, $obj);
	}

	function propOr($default = _, $p = _, $obj = _)
	{
		return _curry3(function($default, $p, $obj) {
			if (is_array($obj)) {
				return array_key_exists($p, $obj) ? $obj[$p] : $default;
			}

			return property_exists($obj, $p) ? $obj->{$p} : $default;
		}, $default, $p, $obj);
	}
}