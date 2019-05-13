<?php

namespace Bramus\Reflection;

/**
 * The ReflectionClass class reports information about a class.
 */
class ReflectionClassConstant extends \ReflectionClassConstant
{
	private $docComment;

	public function __construct($class, string $name)
	{
		parent::__construct($class, $name);
		$this->docComment = $this->extractDocComment();
	}

	public function getSummary()
	{
		return $this->getDocComment()->getSummary() ?: '';
	}

	public function getDescription()
	{
		return (string) $this->getDocComment()->getDescription();
	}

	public function getDocComment()
	{
		return $this->docComment;
	}

	public function getDocCommentString()
	{
		return parent::getDocComment() ?: '';
	}

	private function extractDocComment()
	{
		// Fall back to the beginning of a docbloc if none is set,
		// that way the factory won't fail upon creating an instance.
		$docCommentString = $this->getDocCommentString() ?: '/**';
		$factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();

		return $factory->create($docCommentString);
	}
}
