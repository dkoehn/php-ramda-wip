<?php

use function \PHPRamda\Functions\always;

describe('always', function() {
    it('returns a function that returns the object initially supplied', function() {
        $theMeaning = always(42);
        eq($theMeaning(), 42);
        eq($theMeaning(10), 42);
        eq($theMeaning(false), 42);
    });

    it('works with various types', function() {
        $alwaysFalse = always(false);
        eq($alwaysFalse(false), false);
        $alwaysAbc = always('abc');
        eq($alwaysAbc(), 'abc');
        $alwaysHash = always(['a' => 1, 'b' => 2]);
        eq($alwaysHash(), ['a' => 1, 'b' => 2]);
        $obj = new \stdClass;
        $obj->a = 1;
        $obj->b = 2;
        $alwaysObj = always($obj);
        eq($alwaysObj(), $obj);
        $now = \DateTime::createFromFormat('Y-m-d', '1776-06-04');
        $alwaysNow = always($now);
        eq($alwaysNow(), $now);
        $alwaysNull = always(null);
        eq($alwaysNull(), null);
    });
});
