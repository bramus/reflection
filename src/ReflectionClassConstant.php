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

	public function getSummary(): string
	{
		if (is_a($this->docComment, \phpDocumentor\Reflection\DocBlock::class)) {
			return $this->docComment->getSummary();
		}

		return (string) $this->docComment;
	}

	public function getDescription(): string
	{
		if (is_a($this->docComment, \phpDocumentor\Reflection\DocBlock::class)) {
			return $this->docComment->getDescription();
		}

		if (!$this->docComment) {
			return '';
		}

		return (string) $this->docComment;
	}

	public function getDocCommentString(): string
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
