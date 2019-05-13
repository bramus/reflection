<?php

namespace Bramus\Reflection;

/**
 * The ReflectionClass class reports information about a class.
 */
class ReflectionClass extends \ReflectionClass
{
	private $constants;

	/**
	 * Gets defined constant.
	 *
	 * @param string $name the name of the class constant to get
	 *
	 * @return mixed
	 */
	public function getConstant($name)
	{
		// Constants have not been stored yet, do it first
		if (null === $this->constants) {
			$this->constants = $this->extractConstants($this->getName());
		}

		// Don't allow invalid constant names
		if (0 === sizeof($this->constants) || !isset($this->constants[$name])) {
			throw new \Exception('Invalid Constant Name');
		}

		// Return it!
		return $this->constants[$name];
	}

	/**
	 * Gets constants.
	 *
	 * @return array An array of constants, where the keys hold the name and the values ReflectionConstant instances
	 */
	public function getConstants(): array
	{
		// Constants have already been extracted, return that
		if (null !== $this->constants) {
			return $this->constants;
		}

		$this->constants = $this->extractConstants($this->getName());

		return $this->constants;
	}

	/**
	 * Extracts all constants as ReflectionConstant instances from a given filename.
	 *
	 * @see Looping/Extraction Logic from https://stackoverflow.com/a/22526948/2076595
	 *
	 * @param string $filename  The filename to inspect
	 * @param mixed  $className
	 *
	 * @return array An array of constants, where the keys hold the name and the values ReflectionConstant instances
	 */
	private function extractConstants($className)
	{
		// Initialize constants
		$constants = [];

		// Extract constants using the original getConstants(), so that we know the values
		$origConstants = parent::getConstants();

		// Replace constants with ReflectionClassConstant instances
		if (sizeof($origConstants) > 0) {
			foreach ($origConstants as $constantKey => $constantValue) {
				$constants[$constantKey] = new ReflectionClassConstant($className, $constantKey);
			}
		}

		return $constants;
	}
}
