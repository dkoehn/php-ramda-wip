<?php

namespace PHPRamda\Functions {
	use function \PHPRamda\Internal\_arity;
	use function \PHPRamda\Internal\_curry1;
	use function \PHPRamda\Internal\_curry2;
	use function \PHPRamda\Internal\_curryN;
	use function \PHPRamda\Internal\_numArgs;
	use function \PHPRamda\Internal\_pipe;
	use function \PHPRamda\Internal\_slice;

	use function \PHPRamda\Lists\reduce;
	use function \PHPRamda\Lists\tail;

	const __ = '__PLACHOLDER__';

	function addIndex($fn = __)
	{
		return _curry1(function($fn) {
			return curryN(_numArgs($fn), function(... $arguments) use ($fn) {
				$idx = 0;
				$origFn = $arguments[0];
				$list = $arguments[count($arguments) - 1];
				$args = _slice($arguments);
				$args[0] = function(... $arguments) use ($origFn, &$idx, $list) {
					$newArgs = array_merge($arguments, [$idx, $list]);
					$result = $origFn(... $newArgs);
					$idx += 1;
					return $result;
				};

				return $fn(... $args);
			});
		}, $fn);
	}

	function always($val = __)
	{
		return _curry1(function($val) {
			return function() use ($val) {
				return $val;
			};
		}, $val);
	}

	function ap($applicative = __, $fn = __)
	{
		return _curry2(function($applicative, $fn) {
			if (is_object($applicative) && method_exists($applicative, 'ap')) {
				return $applicative->ap($fn);
			} elseif (is_callable($applicative)) {
				return function($x) use ($applicative, $fn) {
					$appliedFn = $applicative($x);
					return $appliedFn($fn($x));
				};
			}

			$ret = [];
			foreach ($applicative as $f) {
				foreach ($fn as $val) {
					$ret[] = $f($val);
				}
			}
			return $ret;
		}, $applicative, $fn);
	}

	function apply($fn = __, $list = __)
	{
		return _curry2(function($fn, $list) {
			return $fn(...$list);
		}, $fn, $list);
	}

	//TODO: applySpec
	//function applySpec()

	function binary($fn = __)
	{
		return nAry(2, $fn);
	}

	function bind($fn = __, $thisObj = __)
	{
		return _curry2(function($fn, $thisObj) {
			if (!$fn instanceof \Closure) {
				throw new \InvalidArgumentException('$fn must be a \Closure');
			}

			return \Closure::bind($fn, $thisObj);
		}, $fn, $thisObj);
	}

	//TODO: call?



	function comparator($pred = __)
	{
		return _curry1(function($pred) {
			return function($a, $b) use ($pred) {
				return $pred($a, $b) ? -1 : ($pred($b, $a) ? 1 : 0);
			};
		}, $pred);
	}

	function compose(...$args)
	{
		if (count($args) === 0) {
			throw new \Exception('compose requires at least one argument');
		}

		$reversedArgs = array_reverse($args);
		return pipe(...$reversedArgs);
	}

	function construct($type = __)
	{
		return _curry1(function($type) {
			return function(...$args) use ($type) {
				return new $type(...$args);
			};
		}, $type);
	}

	function constructN($n = __, $type = __) {
		return _curry2(function($n, $type) {
			return curryN($n, function(...$args) use ($type) {
				return new $type(...$args);
			});
		}, $n, $type);
	}

	function converge($after = __, $fns = __)
	{
		return _curry2(function($after, $fns) {
			$maxArity = \PHPRamda\Internal\_reduce(\PHPRamda\Relation\max(), 0, \PHPRamda\Lists\map(function($fn) { return _numArgs($fn); }, $fns));
			return curryN($maxArity, function(...$args) use ($after, $fns) {
				$params = \PHPRamda\Lists\map(function($fn) use ($args) {
					return $fn(...$args);
				}, $fns);

				return $after(...$params);
			});
		}, $after, $fns);
	}

	function curry(callable $fn, ...$params)
	{
		$args = array_merge([$fn], $params);
		return _curry1(function($fn, ...$params) {
			return curryN(_numArgs($fn), $fn, ...$params);
		}, ...$args);
	}

	function curryN($arity, callable $fn, ...$params)
	{
		//TODO: Why $arity == 1 doesn't work?
//		if ($arity === 1) {
//			return _curry1($fn, $params);
//		}

		return _arity($arity, _curryN($arity, $params, $fn));
	}

	function F()
	{
		return false;
	}

	function flip($fn = __) {
		return _curry1(function($fn) {
			return curryN(2, function(...$args) use ($fn) {
				$a = $args[0];
				$b = $args[1];

				$args[0] = $b;
				$args[1] = $a;

				return $fn(...$args);
			});
//			return _curry2(function(...$args) use ($fn) {
//				$a = $args[0];
//				$b = $args[1];
//
//				$args[0] = $b;
//				$args[1] = $a;
//
//				return $fn(...$args);
//			});
		}, $fn);
	}

	function identity($val = __)
	{
		return _curry1(function($val) {
			return $val;
		}, $val);
	}

	//TODO: invoker?

	function juxt($fns = __)
	{
		return _curry1(function($fns) {
			return converge(function(...$args) {
				return $args;
			}, $fns);
		}, $fns);
	}

	function memoize($fn = __)
	{
		return _curry1(function($fn) {
			$cache = [];
			return curryN(_numArgs($fn), function(...$args) use ($fn, &$cache) {
				$key = implode('||', \PHPRamda\Lists\map(function($a) {
					if (is_object($a) || is_array($a)) {
						return json_encode($a);
					}
					return $a;
				}, $args));

				if (!array_key_exists($key, $cache)) {
					$cache[$key] = $fn(...$args);
				}

				return $cache[$key];
			});
		}, $fn);
	}

	function nAry($n = __, $fn = __)
	{
		return _curry2(function($n, $fn) {
			$numArgs = _numArgs($fn);
			$callFn = function($args) use ($n, $fn, $numArgs) {
				if ($numArgs > count($args)) {
					for ($i = count($args); $i < $numArgs; $i++) {
						$args[] = null;
					}
				} else {
					$args = array_slice($args, 0, $numArgs);
				}

				return $fn(...$args);
			};
			switch ($n) {
				case 0:
					return function() use ($callFn) { return $callFn([]); };
				case 1:
					return function($a) use ($callFn) { return $callFn([$a]); };
				case 2:
					return function($a, $b) use ($callFn) { return $callFn([$a, $b]); };
				case 3:
					return function($a = null, $b = null, $c = null) use ($callFn) { return $callFn([$a, $b, $c]); };
				case 4:
					return function($a, $b, $c, $d) use ($callFn) { return $callFn([$a, $b, $c, $d]); };
				case 5:
					return function($a, $b, $c, $d, $e) use ($callFn) { return $callFn([$a, $b, $c, $d, $e]); };
				case 6:
					return function($a, $b, $c, $d, $e, $f) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f]); };
				case 7:
					return function($a, $b, $c, $d, $e, $f, $g) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g]); };
				case 8:
					return function($a, $b, $c, $d, $e, $f, $g, $h) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h]); };
				case 9:
					return function($a, $b, $c, $d, $e, $f, $g, $h, $i) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h, $i]); };
				case 10:
					return function($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) use ($callFn) { return $callFn([$a, $b, $c, $d, $e, $f, $g, $h, $i, $j]); };
				default:
					throw new \RuntimeException('First argument to nAry must be a non-negative integer no greater than ten');
			}
		}, $n, $fn);
	}

	function nthArg($n = __)
	{
		return _curry1(function($n) {
			$fn = function(...$args) use ($n) {
				if ($n < 0 && abs($n) > count($args)) {
					return null;
				}

				$ret = array_slice($args, $n, 1);
				return isset($ret[0]) ? $ret[0] : null;
			};
			if ($n >= 0) {
				return curryN($n + 1, $fn);
			} else {
				return $fn;
			}
		}, $n);
	}

	function of($a = __)
	{
		return _curry1(function($a) {
			return [$a];
		}, $a);
	}

	function once($fn = __)
	{
		return _curry1(function($fn) {
			$invoked = false;
			$val = null;
			$n = _numArgs($fn);
			return _arity($n, function(...$args) use ($fn, &$invoked, &$val) {
				if (!$invoked) {
					$val = $fn(...$args);
					$invoked = true;
				}

				return $val;
			});
		}, $fn);
	}

	//TODO: partial
	//TODO: partialRight


	function pipe(...$args)
	{
		if (count($args) === 0) {
			throw new \Exception('pipe requires at least one argument');
		}

		$numArgs = _numArgs($args[0]);
		return _arity($numArgs, reduce(_pipe(), $args[0], tail($args)));
	}

	function T()
	{
		return true;
	}

	function tap($fn = __, $x = __)
	{
		return _curry2(function($fn, $x) {
			$fn($x);
			return $x;
		}, $fn, $x);
	}

	function test($regex = __, $str = __)
	{
		return _curry2(function($regex, $str) {
			if (!is_string($regex) || !is_string($str)) {
				throw new \InvalidArgumentException('Parameters must be strings');
			}

			return preg_match($regex, $str) == 1;
		}, $regex, $str);
	}

	//TODO: tryCatch

	function unapply($fn = __)
	{
		return _curry1(function($fn) {
			return function(...$args) use ($fn) {
				return $fn($args);
			};
		}, $fn);
	}

	function unary($fn = __)
	{
		return _curry1(function($fn) {
			return nAry(1, $fn);
		}, $fn);
	}

	function uncurryN($depth = __, $fn = __)
	{
		return _curry2(function($depth, $fn) {
			return curryN($depth, function(...$args) use ($depth, $fn) {
				$currentDepth = 1;
				$value = $fn;
				$idx = 0;

				while ($currentDepth <= $depth && is_callable($value)) {
					$endIdx = $currentDepth === $depth ? count($args) : $idx + _numArgs($value);
					$params = array_slice($args, $idx, $endIdx - $idx);
					$value = $value(...$params);
					$currentDepth += 1;
					$idx = $endIdx;
				}

				return $value;
			});
		}, $depth, $fn);
	}

	function useWith($fn = __, $fns = __)
	{
		return _curry2(function($fn, $fns) {
			return _arity(count($fns), function(...$args) use ($fn, $fns) {
				$params = [];
				for ($i = 0; $i < count($args); $i++) {
					if ($i < count($fns)) {
						$transformer = $fns[$i];
						$params[] = $transformer($args[$i]);
					} else {
						$params[] = $args[$i];
					}
				}

				return $fn(...$params);
			});
		}, $fn, $fns);
	}

	function wrap($next = __, $fn = __)
	{
		return _curry2(function($next, $fn) {
			$numArgs = _numArgs($next);
			return nAry($numArgs, function(...$args) use ($next, $fn) {
				return $fn($next, ...$args);
			});
		}, $next, $fn);
	}
}
