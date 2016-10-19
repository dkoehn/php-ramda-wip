<?php

use function \PHPRamda\Functions\ap;
use function \PHPRamda\Math\add;
use function \PHPRamda\Math\multiply;

describe('ap', function() {
    it('interprets [a] as an applicative', function() {
        $mult2 = multiply(2);
        $plus3 = add(3);

        eq(ap([$mult2, $plus3], [1, 2, 3]), [2, 4, 6, 4, 5, 6]);
    });

    it('interprets ((->) r) as an applicative', function() {
        $f = function($r) {
        return function($a) use ($r) {
            return $r + $a;
            };
        };
        $g = function($r) { return $r * 2; };
        $h = ap($f, $g);
        // (<*>) :: (r -> a -> b) -> (r -> a) -> (r -> b)
        // f <*> g = \x -> f x (g x)
        eq($h(10), 10 + (10 * 2));

        $i = ap(add());
        $j = $i($g);
        eq($j(10), 10 + (10 * 2));
    });

    it('dispatches to the passed object\'s ap method when values is a non-Array object', function() {
        $obj = new ApTestObject;
        eq(ap($obj, 10), $obj->ap(10));
    });

    it('is curried', function() {
        $mult2 = multiply(2);
        $plus3 = add(3);
        $val = ap([$mult2, $plus3]);
        eq(is_callable($val), true);
        eq($val([1, 2, 3]), [2, 4, 6, 4, 5, 6]);
    });
});

class ApTestObject
{
    public function ap($n) {
        return 'called ap with '.$n;
    }
}
