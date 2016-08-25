<?php

namespace PHPRambda\Math {
  use const \PHPRambda\Functions\_;
  use function \PHPRambda\Internal\_curry2;

  function add($a = _, $b = _)
  {
    return _curry2(function($a, $b) {
      return $a + $b;
    }, $a, $b);
  }

  function subtract($a = _, $b = _)
  {
    return _curry2(function($a, $b) {
      return $a - $b;
    }, $a, $b);
  }

  function multiply($a = _, $b = _)
  {
    return _curry2(function($a, $b) {
      return $a * $b;
    }, $a, $b);
  }

  function max($a = _, $b = _)
  {
    return _curry2(function($a, $b) {
      return $a > $b ? $a : $b;
    }, $a, $b);
  }
}
