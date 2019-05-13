<?php

namespace Tests\Bramus\Reflection;

use Bramus\Reflection\ReflectionClass;
use Bramus\Reflection\ReflectionClassConstant;
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

		$this->assertInstanceOf(ReflectionClassConstant::class, $constant);
		$this->assertEquals('MONDAY', $constant->getName());
		$this->assertEquals(1, $constant->getValue());
		$this->assertEquals('Monday.', $constant->getSummary());
	}
}
