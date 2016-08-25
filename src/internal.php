<?php

namespace PHPRambda\Internal {

	use const \PHPRambda\Functions\_;

	function _numArgs(callable $callable)
	{
		if ($callable instanceOf \Closure || is_string($callable)) {
			$reflector = new \ReflectionFunction($callable);
		} elseif (is_array($callable)) {
			$reflector = new \ReflectionMethod($callable[0], $callable[1]);
		} else {
			$reflector = new \ReflectionMethod($callable[0], '__invoke');
		}

		return $reflector->getNumberOfParameters();
	}

	function _curry1(callable $fn, $a = _)
	{
		if (_isPlaceholder($a)) {
			return function($a) use ($fn) {
				return $fn($a);
			};
		}

		return $fn($a);
	}

	function _curry2(callable $fn, $a = _, $b = _)
	{
		if (!_isPlaceholder($a) && !_isPlaceholder($b)) {
			return $fn($a, $b);
		}

		if (_isPlaceholder($a) && _isPlaceholder($b)) {
			return function($a = _, $b = _) use ($fn) {
				return _curry2($fn, $a, $b);
			};
		} elseif (_isPlaceholder($a)) {
			return _curry1(function($_a) use ($fn, $b) {
				return $fn($_a, $b);
			});
		} else {
			return _curry1(function($_b) use ($fn, $a) {
				return $fn($a, $_b);
			});
		}
	}

	function _curry3(callable $fn, $a = _, $b = _, $c = _)
	{
		if (!_isPlaceholder($a) && !_isPlaceholder($b) && !_isPlaceholder($c)) {
			return $fn($a, $b, $c);
		}

		if (_isPlaceholder($a) && _isPlaceholder($b) && _isPlaceholder($c)) {
			return function($a = _, $b = _, $c = _) use ($fn) {
				return _curry3($fn, $a, $b, $c);
			};
		}

		if (_isPlaceholder($a)) {
			if (_isPlaceholder($b)) {
				return _curry2(function($_a, $_b) use ($fn, $c) {
					return $fn($_a, $_b, $c);
				});
			} elseif (_isPlaceholder($c)) {
				return _curry2(function($_a, $_c) use ($fn, $b) {
					return $fn($_a, $b, $_c);
				});
			} else {
				return _curry1(function($_a) use ($fn, $b, $c) {
					return $fn($_a, $b, $c);
				});
			}
		} elseif (_isPlaceholder($b)) {
			if (_isPlaceholder($c)) {
				return _curry2(function($_b, $_c) use ($fn, $a) {
					return $fn($a, $_b, $_c);
				});
			} else {
				return _curry1(function($_b) use ($fn, $a, $c) {
					return $fn($a, $_b, $c);
				});
			}
		} else {
			return _curry1(function($_c) use ($fn, $a, $b) {
				return $fn($a, $b, $_c);
			});
		}
	}

	function _curryN($length, $params, $fn)
	{
		return function(...$arguments) use ($length, $params, $fn) {
			$combined = [];
			$argsIdx = 0;
			$left = $length;
			$combinedIdx = 0;
			while ($combinedIdx < count($params) || $argsIdx < count($arguments)) {
				if ($combinedIdx < count($params) &&
					(!_isPlaceholder($params[$combinedIdx]) ||
						$argsIdx >= count($arguments))
				) {
					$result = $params[$combinedIdx];
				} else {
					$result = $arguments[$argsIdx];
					$argsIdx += 1;
				}
				$combined[$combinedIdx] = $result;
				if (!_isPlaceholder($result)) {
					$left -= 1;
				}
				$combinedIdx += 1;
			}

			return $left <= 0 ? $fn(...$combined)
				: _arity($left, _curryN($length, $combined, $fn));
		};
	}

	function _arity($n, $fn)
	{
		switch ($n) {
			case 0:
				return function() use ($fn) {
					return $fn;
				};
			case 1:
				return function($a) use ($fn) {
					return $fn($a);
				};
			case 2:
				return function($a, $b) use ($fn) {
					return $fn($a, $b);
				};
			case 3:
				return function($a, $b, $c) use ($fn) {
					return $fn($a, $b, $c);
				};
			case 4:
				return function($a, $b, $c, $d) use ($fn) {
					return $fn($a, $b, $c, $d);
				};
			case 5:
				return function($a, $b, $c, $d, $e) use ($fn) {
					return $fn($a, $b, $c, $d, $e);
				};
			case 6:
				return function($a, $b, $c, $d, $e, $f) use ($fn) {
					return $fn($a, $b, $c, $d, $e, $f);
				};
			case 7:
				return function($a, $b, $c, $d, $e, $f, $g) use ($fn) {
					return $fn($a, $b, $c, $d, $e, $f, $g);
				};
			case 8:
				return function($a, $b, $c, $d, $e, $f, $g, $h) use ($fn) {
					return $fn($a, $b, $c, $d, $e, $f, $g, $h);
				};
			case 9:
				return function($a, $b, $c, $d, $e, $f, $g, $h, $i) use ($fn) {
					return $fn($a, $b, $c, $d, $e, $f, $g, $h, $i);
				};
			case 10:
				return function($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) use ($fn) {
					return $fn($a, $b, $c, $d, $e, $f, $g, $h, $i, $j);
				};
			default:
				throw new \RuntimeException('First argument to _arity must be a non-negative integer no greater than ten');
		}
	}

	function _isPlaceholder($val)
	{
		return $val === _;
	}

	function _isFunction($f)
	{
		return is_callable($f);
	}

	function _reduce($fn, $acc, $list)
	{
		foreach ($list as $key => $value) {
			$args = [$acc, $value, $key];
			$acc = $fn(...$args);
		}

		return $acc;
	}

	function _slice($args, $from = null, $to = null)
	{
		switch (func_num_args()) {
			case 1:
				return _slice($args, 0, count($args));
			case 2:
				return _slice($args, $from, count($args));
			default:
				return array_slice($args, $from, $to);
		}
	}
}
