<?php

use function \PHPRamda\Lists\last;

describe('last', function() {
    it('returns the last element of an ordered collection', function() {
        eq(last([1, 2, 3]), 3);
        eq(last([1, 2]), 2);
        eq(last([1]), 1);
        eq(last([]), null);
    });

    it('returns the last character of a string', function() {
        eq(last('abc'), 'c');
        eq(last('ab'), 'b');
        eq(last('a'), 'a');
        eq(last(''), '');
    });

    it('throws if applied to null', function() {
        try {
            last(null);
            fail();
        } catch (\Exception $e) {
            eq($e->getMessage(), 'Invalid type');
        }
    });
});
