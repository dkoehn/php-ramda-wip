<?php

use function \PHPRamda\Lists\head;

describe('head', function() {
    it('returns the first element of an ordered collection', function() {
        eq(head([1, 2, 3]), 1);
        eq(head([2, 3]), 2);
        eq(head([3]), 3);
        eq(head([]), null);
    });

    it('returns the first character of a string', function() {
        eq(head('abc'), 'a');
        eq(head('bc'), 'b');
        eq(head('c'), 'c');
        eq(head(''), '');
    });

    it('throws if applied to null', function() {
        try {
            head(null);
            fail();
        } catch (\Exception $e) {
            eq($e->getMessage(), 'Invalid type');
        }
    });
});
