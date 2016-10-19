<?php

use function \PHPRamda\Lists\nth;

describe('nth', function() {
    $list = ['foo', 'bar', 'baz', 'quux'];

    it('accepts positive offsets', function() use ($list) {
        eq(nth(0, $list), 'foo');
        eq(nth(1, $list), 'bar');
        eq(nth(2, $list), 'baz');
        eq(nth(3, $list), 'quux');
        eq(nth(4, $list), null);

        eq(nth(0, 'abc'), 'a');
        eq(nth(1, 'abc'), 'b');
        eq(nth(2, 'abc'), 'c');
        eq(nth(3, 'abc'), '');
    });

    it('accepts negative offsets', function() use ($list) {
        eq(nth(-1, $list), 'quux');
        eq(nth(-2, $list), 'baz');
        eq(nth(-3, $list), 'bar');
        eq(nth(-4, $list), 'foo');
        eq(nth(-5, $list), null);

        eq(nth(-1, 'abc'), 'c');
        eq(nth(-2, 'abc'), 'b');
        eq(nth(-3, 'abc'), 'a');
        eq(nth(-4, 'abc'), '');
    });

    it('throws if applied to null', function() {
        try {
            nth(0, null);
            fail();
        } catch (\Exception $e) {
            eq($e->getMessage(), 'Invalid type');
        }
    });
});
