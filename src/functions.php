<?php

namespace PHPRambda\Functions
{
  use function \PHPRambda\Internal\_numArgs;
  use function \PHPRambda\Internal\_curry1;
  use function \PHPRambda\Internal\_curry2;
  use function \PHPRambda\Internal\_curryN;
  use function \PHPRambda\Internal\_arity;
  use function \PHPRambda\Internal\_isPlaceholder;

  use function \PHPRambda\Lists\map;
  use function \PHPRambda\Lists\reduce;
  use function \PHPRambda\Lists\tail;

  use function \PHPRambda\Logic\_and;

  const _ = '__PLACHOLDER__';

  function addIndex($fn = _, $list = _)
  {
    return _curry2(function($fn, $list) {
      $idx = 0;
      foreach ($list as $val) {
        yield $fn($val, $idx++);
      }
    });
  }

  function always($v = _)
  {
    return _curry1(function($v) {
      return $v;
    }, $v);
  }

  function ap($funcs = _, $list = _)
  {
    return _curry2(function($funcs, $list) {
      foreach ($funcs as $func) {
        foreach ($list as $val) {
          yield $func($val);
        }
      }
    }, $funcs, $list);
  }

  function apply($fn = _, $list = _)
  {
    return _curry2( function($fn, $list) {
      return $fn(...$list);
    }, $fn, $list);
  }
  //
  // function applySpec($obj = _, $fn = _, ...$params)
  // {
  //
  // }

  function binary($fn = _)
  {
    if (_isPlaceholder($fn)) {
      return _curry1(function($fn) {
        return nAry(2, $fn);
      });
    }

    return nAry(2, $fn);
  }

  // function bind()
  // {
  //
  // }


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

  function compose(...$args)
  {
    if (count($args) === 0) {
      throw new \RuntimeException('compose requires at least one argument');
    }

    $args = array_reverse($args);

    return pipe(...$args);
  }

  function converge($after = _, $fns = _)
  {
    return _curry2(function($after, $fns) {
      return function(...$args) use ($after, $fns) {
        $params = [];
        foreach ($fns as $fn) {
          $params[] = $fn(...$args);
        }

        return $after(...$params);
      };
    }, $after, $fns);
  }

  function lift($fn = _)
  {
    return _curry1(function($fn) {
      return liftN(_numArgs($fn), $fn);
    }, $fn);
  }

  function liftN($arity = _, $fn = _)
  {
    return _curry2(function($arity, $fn) {
      $lifted = curryN($arity, $fn);
      return curryN($arity, function(...$args) use ($lifted) {
        return _reduce(ap(), map($lifted, $args[0]), _slice($args, 1));
      });
    }, $arity, $fn);
  }

  function nAry($n, $fn)
  {
    return _curry2(function($n, $fn) {
      $numArgs = _numArgs($fn);
      $np = array_fill(0, $numArgs - $n, null);
      switch ($n) {
        case 0: return function() use ($fn) { return $fn; };
        case 1: return function($a) use ($fn, $np) { return $fn($a, ...$np); };
        case 2: return function($a, $b) use ($fn, $np) { return $fn($a, $b, ...$np); };
        case 3: return function($a, $b, $c) use ($fn, $np) { return $fn($a, $b, $c, ...$np); };
        case 4: return function($a, $b, $c, $d) use ($fn, $np) { return $fn($a, $b, $c, $d, ...$np); };
        case 5: return function($a, $b, $c, $d, $e) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, ...$np); };
        case 6: return function($a, $b, $c, $d, $e, $f) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, $f, ...$np); };
        case 7: return function($a, $b, $c, $d, $e, $f, $g) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, $f, $g, ...$np); };
        case 8: return function($a, $b, $c, $d, $e, $f, $g, $h) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, $f, $g, $h, ...$np); };
        case 9: return function($a, $b, $c, $d, $e, $f, $g, $h, $i) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, $f, $g, $h, $i, ...$np); };
        case 10: return function($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) use ($fn, $np) { return $fn($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, ...$np); };
        default: throw new \RuntimeException('First argument to nAry must be a non-negative integer no greater than ten');
      }
    }, $n, $fn);
  }

  function pipe(...$fns)
  {
    if (count($fns) === 0) {
      throw new \RuntimeException('pipe requires at least one argument');
    }

    return function(...$args) use ($fns) {
      $fn = $fns[0];
      $acc = $fn(...$args);

      for ($i = 1; $i < count($fns); $i++) {
        $fn = $fns[$i];
        $acc = $fn($acc);
      }

      return $acc;
    };
  }
}
