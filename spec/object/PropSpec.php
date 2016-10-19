<?php

use function \PHPRamda\Object\prop;

describe('prop', function() {
    it('returns a function that fetches the appropriate property', function() {
        $fred = [
            'name' => 'Fred',
            'age' => 23,
        ];

        $nm = prop('name');
        eq(is_callable($nm), true);
        eq($nm($fred), 'Fred');
    });
});
