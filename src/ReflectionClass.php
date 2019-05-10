<?php

namespace Bramus\Reflection;

use Bramus\Reflection\Type\ReflectionConstant;

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
		// Constants have not been extracted yet, do it first
		if (null === $this->constants) {
			$this->constants = $this->getConstants();
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

		$this->constants = $this->extractConstants();

		return $this->constants;
	}

	/**
	 * Extracts all constants as ReflectionConstant instances from a given filename.
	 *
	 * @see Looping/Extraction Logic from https://stackoverflow.com/a/22526948/2076595
	 *
	 * @param string $filename The filename to inspect
	 *
	 * @return array An array of constants, where the keys hold the name and the values ReflectionConstant instances
	 */
	private function extractConstants()
	{
		// Extract using the original getConstants(), so that we know the values
		$origConstants = (new \ReflectionClass($this->getName()))->getConstants();

		// Quit while you're ahead
		if (0 === sizeof($origConstants)) {
			return $origConstants;
		}

		// Constants we're about to return …
		$contants = [];

		// Loop all tokens and keep track of the comments. When we encounter a
		// T_CONST (= const definition) followed by a T_STRING (= name of the const)
		// we have collected all required data and we store it.
		$content = file_get_contents($this->getFileName());
		$tokens = token_get_all($content);

		$doc = null;
		$isConst = false;
		foreach ($tokens as $token) {
			if (!is_array($token) || count($token) <= 1) {
				continue;
			}

			list($tokenType, $tokenValue) = $token;

			switch ($tokenType) {
				// ignored tokens
				case T_WHITESPACE:
					break;

				case T_DOC_COMMENT:
				case T_COMMENT:
					$doc = $tokenValue;
					break;

				case T_CONST:
					$isConst = true;
					break;

				case T_STRING:
					if ($isConst) {
						$constants[] = new ReflectionConstant(
							$tokenValue,
							$origConstants[$tokenValue],
							self::clean($doc)
						);
					}
					$doc = null;
					$isConst = false;
					break;

				// all other tokens reset the parser
				default:
					$doc = null;
					$isConst = false;
					break;
			}
		}

		return array_combine(
			array_keys($origConstants),
			$constants
		);
	}

	/**
	 * Cleans the doc comment. Returns null if the doc comment is null.
	 *
	 * @see Cleanup Logic from https://stackoverflow.com/a/22526948/2076595
	 *
	 * @param string $doc The comment
	 *
	 * @return string The cleaned comment
	 */
	private static function clean($doc)
	{
		if (null === $doc) {
			return null;
		}

		$result = null;
		$lines = preg_split('/\R/', $doc);
		foreach ($lines as $line) {
			$line = trim($line, "/* \t\x0B\0");
			if ('' === $line) {
				continue;
			}

			if (null != $result) {
				$result .= ' ';
			}
			$result .= $line;
		}

		return $result;
	}
}
