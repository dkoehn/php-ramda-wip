<?php

use function PHPRamda\Functions\construct;

describe('construct', function() {
	class Rectangle
	{
		public $width;
		public $height;

		public function __construct($width, $height)
		{
			$this->width = $width;
			$this->height = $height;
		}

		public function area()
		{
			return $this->width * $this->height;
		}
	}

	it('turns a constructor function into one that can be called without `new`', function() {
		$rect = construct(Rectangle::class);
		$r1 = $rect(3, 4);
		eq(get_class($r1), Rectangle::class);
		eq($r1->width, 3);
		eq($r1->area(), 12);
	});

	it('ca be used to create a DateTime object', function() {
		$date = construct(DateTime::class);
		$date = $date('2017-01-04 12:57:26');

		eq(get_class($date), DateTime::class);
		eq($date->format('Y'), '2017');
	});
});