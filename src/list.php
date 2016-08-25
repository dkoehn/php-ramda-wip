<?php

namespace PHPRambda\Lists {
  use const PHPRambda\Functions\_;
  use function PHPRambda\Internal\_curry1;
  use function PHPRambda\Internal\_curry2;
  use function PHPRambda\Internal\_curry3;
  use function PHPRambda\Internal\_reduce;

  function map($fn = _, $list = _)
  {
    return _curry2(function($fn, $list) {
      foreach ($list as $k => $val) {
        yield $k => $fn($val);
      }
    }, $fn, $list);
  }

  function reduce($fn = _, $acc = _, $list = _)
  {
    return _curry3(function($fn, $acc, $list) {
      return _reduce($fn, $acc, $list);
    }, $fn, $acc, $list);
  }

  function reverse($list = _)
  {
    return _curry1(function($list) {
      if (is_string($list)) {
        $list = str_split($list);
      }

      return array_reverse($list);
    }, $list);
  }

  function tail($list = _)
  {
    return _curry1(function($list) {
      return array_slice($list, 1, count($list));
    }, $list);
  }
}
