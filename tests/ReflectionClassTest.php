<?php

namespace Tests\Bramus\Reflection;

use Bramus\Reflection\ReflectionClass;
use Bramus\Reflection\Type\ReflectionConstant;
use PHPUnit\Framework\TestCase;
use Tests\Bramus\Reflection\Examples\Weekday;

/**
 * @internal
 * @coversDefaultClass \Bramus\Reflection\ReflectionClass
 */
class ReflectionClassTest extends TestCase
{
	public function testGetConstants()
	{
		$reflected = new ReflectionClass(Weekday::class);
		$constants = $reflected->getConstants();

		$this->assertCount(8, $constants);
	}

	public function testGetConstant()
	{
		$reflected = new ReflectionClass(Weekday::class);
		$constant = $reflected->getConstant('MONDAY');

		$this->assertInstanceOf(ReflectionConstant::class, $constant);
		$this->assertEquals($constant->getName(), 'MONDAY');
		$this->assertEquals($constant->getValue(), 1);
		$this->assertEquals($constant->getDescription(), 'Monday.');
	}
}
