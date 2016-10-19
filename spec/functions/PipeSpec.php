<?php

use function \PHPRamda\Functions\pipe;
use function \PHPRamda\Lists\map;
use function \PHPRamda\Math\multiply;
use function \PHPRamda\Internal\_numArgs;

describe('pipe', function() {
    it('performs left-to-right function composition', function() {
        $f = pipe('intval', multiply(), map());

        assertThat(_numArgs($f), identicalTo(2));
        $g = $f('10');
        assertThat($g([1, 2, 3]), identicalTo([10, 20, 30]));
        $h = $f('10', 2);
        assertThat($h([1, 2, 3]), identicalTo([2, 4, 6]));
    });

    it('throws if given no arguments', function() {
        try {
            pipe();
            fail();
        } catch (\Exception $e) {
            eq($e->getMessage(), 'pipe requires at least one argument');
        }
    });

    it('can be applied to one argument', function() {
        $f = function($a, $b, $c) { return [$a, $b, $c]; };
        $g = pipe($f);
        eq(_numArgs($g), 3);
        eq($g(1, 2, 3), [1, 2, 3]);
    });

    context('compose properties', function() {
        it('pipes two functions', function() {
            $f = function($x) { return $x + 2; };
            $g = function($x) { return $x * 2; };

            $expected = $g($f(3));

            $h = pipe($f, $g);
            eq($h(3), $expected);
        });

        it('is associative', function() {
            $f = function($x) { return $x + 2; };
            $g = function($x) { return $x * 2; };
            $h = function($x) { return $x / 3; };

            $expected = $h($g($f(9)));
            $i = pipe($f, $g, $h);
            eq($i(9), $expected);

            $i = pipe($f, pipe($g, $h));
            eq($i(9), $expected);

            $i = pipe(pipe($f, $g), $h);
            eq($i(9), $expected);
        });
    });
});
