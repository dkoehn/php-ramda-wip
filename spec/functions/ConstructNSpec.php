<?php

use function PHPRamda\Functions\constructN;

describe('constructN', function() {
	class Circle
	{
		public $radius;
		public $color;

		public function __construct($radius)
		{
			$this->radius = $radius;

			$args = func_get_args();
			$this->color = isset($args[1]) ? $args[1] : null;
		}

		public function area()
		{
			return pi() * pow($this->radius, 2);
		}
	}

	class G
	{
		public $a;
		public $b;
		public $c;

		public function __construct($a, $b, $c = null)
		{
			$this->a = $a;
			$this->b = $b;
			$this->c = $c;
		}
	}

	it('turns a constructor function into a function with n arguments', function() {
		$circle = constructN(2, Circle::class);
		$c1 = $circle(1, 'red');
		eq(get_class($c1), Circle::class);
		eq($c1->radius, 1);
		eq($c1->area(), pi());
		eq($c1->color, 'red');
	});

	it('ca be used to create a DateTime object', function() {
		$date = constructN(1, DateTime::class);
		$date = $date('2017-01-04 12:57:26');

		eq(get_class($date), DateTime::class);
		eq($date->format('Y'), '2017');
	});

	it('is curried', function() {
		$construct2 = constructN(2);
		$g2 = $construct2(G::class);
		eq(get_class($g2('a', 'b')), G::class);
		$g3 = $g2('a');
		eq(get_class($g3('b')), G::class);
	});
});