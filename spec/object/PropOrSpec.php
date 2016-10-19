<?php

use function \PHPRamda\Object\propOr;

describe('propOr', function() {
    $fred = ['name' => 'Fred', 'age' => 23];
    $anon = ['age' => 99];

    $nm = propOr('Unknown', 'name');

    it('returns a function that fetches the appropriate property', function() use ($nm, $fred) {
        eq(is_callable($nm), true);
        eq($nm($fred), 'Fred');
    });

    it('returns the default value when the property does not exist', function() use ($nm, $anon) {
        eq($nm($anon), 'Unknown');
    });

    it('returns the default value when the object is nil', function() use ($nm) {
        eq($nm(null), 'Unknown');
    });
});
