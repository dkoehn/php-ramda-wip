<?php

use function \PHPRamda\Functions\addIndex;
use function \PHPRamda\Lists\map;
use function \PHPRamda\Lists\reduce;

describe('addIndex', function() {
    context('unary functions like `map`', function() {
        $times2 = function($x) { return $x * 2; };
        $addIndexParam = function($x, $idx) { return $x + $idx; };
        $squareEnds = function($x, $idx, $list) {
            return ($idx === 0 || $idx === count($list) - 1) ? $x * $x : $x;
        };
        $mapIndexed = addIndex(map());

        it('works just like a normal map', function() use ($times2, $mapIndexed) {
            eq($mapIndexed($times2, [1, 2, 3, 4]), [2, 4, 6, 8]);
        });

        it('passes the index as a second parameter to the callback', function() use ($addIndexParam, $mapIndexed) {
            eq($mapIndexed($addIndexParam, [8, 6, 7, 5, 3, 0, 9]), [8, 7, 9, 8, 7, 5, 15]); // [8 + 0, 6 + 1...]
        });

        it('passes the entire list as a third parameter to the callback', function() use ($squareEnds, $mapIndexed) {
            eq($mapIndexed($squareEnds, [8, 6, 7, 5, 3, 0, 9]), [64, 6, 7, 5, 3, 0, 81]);
        });

        it('acts as a curried function', function() use ($squareEnds, $mapIndexed) {
            $makeSquareEnds = $mapIndexed($squareEnds);
            eq($makeSquareEnds([8, 6, 7, 5, 3, 0, 9]), [64, 6, 7, 5, 3, 0, 81]);
        });
    });

      describe('binary functions like `reduce`', function() {
        $reduceIndexed = addIndex(reduce());
        $timesIndexed = function($tot, $num, $idx) {return $tot + ($num * $idx);};
        $objectify = function($acc, $elem, $idx) { $acc[$elem] = $idx; return $acc;};

        it('passes the index as a third parameter to the predicate', function() use ($reduceIndexed, $timesIndexed, $objectify) {
            eq($reduceIndexed($timesIndexed, 0, [1, 2, 3, 4, 5]), 40);
            eq($reduceIndexed($objectify, [], ['a', 'b', 'c', 'd', 'e']), ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3, 'e' => 4]);
        });

        it('passes the entire list as a fourth parameter to the predicate', function() use ($reduceIndexed) {
            $list = [1, 2, 3];
            $reduceIndexed(function($acc, $x, $idx, $ls) use ($list) {
                eq($ls, $list);
                return $acc;
            }, 0, $list);
        });
      });
});
