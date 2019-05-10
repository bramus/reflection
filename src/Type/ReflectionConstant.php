<?php

namespace Bramus\Reflection\Type;

class ReflectionConstant
{
	private $name;
	private $value;
	private $description;

	public function __construct($name, $value, $description)
	{
		$this->name = $name;
		$this->value = $value;
		$this->description = $description;
	}

	public function __toString()
	{
		// For compatibility reasons we choose to return the name
		return $this->name;
	}

	/**
	 * Gets the name for this constant.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Gets the value for this constant.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Gets the description for this constant.
	 *
	 * @return string|null
	 */
	public function getDescription()
	{
		return $this->description;
	}
}
