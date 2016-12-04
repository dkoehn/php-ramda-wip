<?php

namespace PHPRamda\Internal {

	use const \PHPRamda\Functions\__;

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

	function _curry1(callable $fn, $a = __)
	{
		if (_isPlaceholder($a)) {
			return function($a) use ($fn) {
				return $fn($a);
			};
		}

		return $fn($a);
	}

	function _curry2(callable $fn, $a = __, $b = __)
	{
		if (!_isPlaceholder($a) && !_isPlaceholder($b)) {
			return $fn($a, $b);
		}

		if (_isPlaceholder($a) && _isPlaceholder($b)) {
			return function($a = __, $b = __) use ($fn) {
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

	function _curry3(callable $fn, $a = __, $b = __, $c = __)
	{
		if (!_isPlaceholder($a) && !_isPlaceholder($b) && !_isPlaceholder($c)) {
			return $fn($a, $b, $c);
		}

		if (_isPlaceholder($a) && _isPlaceholder($b) && _isPlaceholder($c)) {
			return function($a = __, $b = __, $c = __) use ($fn) {
				return _curry3($fn, $a, $b, $c);
			};
		}

		if (_isPlaceholder($a)) {
			if (_isPlaceholder($b)) {
				return _curry2(function($_a, $_b = __) use ($fn, $c) {
					return $fn($_a, $_b, $c);
				});
			} elseif (_isPlaceholder($c)) {
				return _curry2(function($_a, $_c = __) use ($fn, $b) {
					return $fn($_a, $b, $_c);
				});
			} else {
				return _curry1(function($_a) use ($fn, $b, $c) {
					return $fn($_a, $b, $c);
				});
			}
		} elseif (_isPlaceholder($b)) {
			if (_isPlaceholder($c)) {
				return _curry2(function($_b, $_c = __) use ($fn, $a) {
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
					$args = func_get_args();
					return $fn(...$args);
				};
			case 1:
				return function($a) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 2:
				return function($a, $b = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 3:
				return function($a, $b = __, $c = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 4:
				return function($a, $b = __, $c = __, $d = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 5:
				return function($a, $b = __, $c = __, $d = __, $e = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 6:
				return function($a, $b = __, $c = __, $d = __, $e = __, $f = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 7:
				return function($a, $b = __, $c = __, $d = __, $e = __, $f = __, $g = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 8:
				return function($a, $b = __, $c = __, $d = __, $e = __, $f = __, $g = __, $h = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 9:
				return function($a, $b = __, $c = __, $d = __, $e = __, $f = __, $g = __, $h = __, $i = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			case 10:
				return function($a, $b = __, $c = __, $d = __, $e = __, $f = __, $g = __, $h = __, $i = __, $j = __) use ($fn) {
					$args = func_get_args();
					return $fn(...$args);
				};
			default:
				throw new \RuntimeException('First argument to _arity must be a non-negative integer no greater than ten');
		}
	}

	function _isPlaceholder($val)
	{
		return $val === __;
	}

	function _reduce($fn, $acc, $list)
	{
		foreach ($list as $value) {
			$args = [$acc, $value];
			$acc = $fn(...$args);
		}

		return $acc;
	}

	function _slice($args, $from = 0, $to = null)
	{
		if ($to === null) {
			return _slice($args, $from, count($args));
		}

		$list = [];
		$idx = 0;
		$len = max(0, min(count($args), $to) - $from);
		while ($idx < $len) {
			$list[$idx] = $args[$from + $idx];
			$idx += 1;
		}
		return $list;
	}

	function _pipe($f = __, $g = __)
	{
		return _curry2(function($f, $g) {
			return function(...$args) use ($f, $g) {
				return $g($f(...$args));
			};
		}, $f, $g);
	}
}
