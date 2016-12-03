<?php

if (!function_exists('eq')) {
	function eq($actual, $expected)
	{
		assertThat($actual, identicalTo($expected));
	}
}
