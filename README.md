# `bramus/reflection`

[![Build Status](https://img.shields.io/travis/bramus/reflection.svg?style=flat-square)](http://travis-ci.org/bramus/reflection) [![Source](http://img.shields.io/badge/source-bramus/reflection-blue.svg?style=flat-square)](https://github.com/bramus/reflection) [![Version](https://img.shields.io/packagist/v/bramus/reflection.svg?style=flat-square)](https://packagist.org/packages/bramus/reflection) [![Downloads](https://img.shields.io/packagist/dt/bramus/reflection.svg?style=flat-square)](https://packagist.org/packages/bramus/reflection/stats) [![License](https://img.shields.io/packagist/l/bramus/reflection.svg?style=flat-square)](https://github.com/bramus/reflection/blob/master/LICENSE)

`bramus/reflection` is a library that tries to make [PHP's built-in Reflection](https://www.php.net/manual/en/book.reflection.php) better.

Built by Bram(us) Van Damme _([https://www.bram.us](https://www.bram.us))_ and [Contributors](https://github.com/bramus/reflection/graphs/contributors)

## Prerequisites/Requirements

- PHP 7.2 or greater

## Installation

Installation is possible using Composer

```
$ composer require bramus/reflection ~1.0
```

## Usage

### A note

All classes in `bramus/reflection` extend PHP's built-in versions. Therefore they have all of the functions like their parent class:

- `\Bramus\Reflection\ReflectionClass` extends [PHP's built-in `ReflectionClass`](https://www.php.net/manual/en/class.reflectionclass.php).
- `\Bramus\Reflection\ReflectionClassConstant` extends [PHP's built-in `ReflectionClassConstant`](https://www.php.net/manual/en/class.reflectionclassconstant.php).

### `ReflectionClass`

When compared to `\ReflectionClass`, `\Bramus\Reflection\ReflectionClass` works exactly the same, but will:

- Return an associate array containing `\Bramus\Reflection\ReflectionClassConstant` instances _(instead of simple values)_ when calling [`getConstants()`](https://www.php.net/manual/en/reflectionclass.getconstants.php).
- Return a `\Bramus\Reflection\ReflectionClassConstant` instance _(instead of simple value)_ when calling [`getConstant()`](https://www.php.net/manual/en/reflectionclass.getconstant.php).

Here's an example comparing `getConstant()`;

- Using PHP's built-in `ReflectionClass`:

	```php
	class Weekday
	{
		/**
		 * Monday
		 */
		const MONDAY = 1;

		/**
		 * Tuesday
		 */
		const TUESDAY = …
	}

	$reflected = new \ReflectionClass(Weekday::class);
	$constant = $reflected->getConstant('MONDAY');

	var_dump($constant);
	// int(1)
	```

- Using `\Bramus\Reflection\ReflectionClass`:

	```php
	class Weekday
	{
		/**
		 * Monday
		 */
		const MONDAY = 1;

		/**
		 * Tuesday
		 */
		const TUESDAY = …
	}

	$reflected = new \Bramus\Reflection\ReflectionClass(Weekday::class);
	$constants = $reflected->getConstant('MONDAY');

	var_dump($constant);
	// object(Bramus\Reflection\ReflectionClassConstant)#40 (2) {
	//   ["name"]=>
	//   string(6) "MONDAY"
	//   ["class"]=>
	//   string(7) "Weekday"
	//   ["docComment":"Bramus\Reflection\ReflectionClassConstant":private]=>
	//   object(phpDocumentor\Reflection\DocBlock)#86 (7) {
	//     …
	//   }
	// }
	```

### `ReflectionClassConstant`

When compared to `\ReflectionClassConstant`, `\Bramus\Reflection\ReflectionClassConstant` works exactly the same, but will:

- Return a `\phpDocumentor\Reflection\DocBlock` instance _(instead of a string)_ when calling [`getDocComment()`](https://www.php.net/manual/en/reflectionclassconstant.getdoccomment.php)
- Provide you with a `getDocCommentString()` method in case you want to access the contents as [`\ReflectionClassConstant::getDocComment()`](https://www.php.net/manual/en/reflectionclassconstant.getdoccomment.php) would return
- Provide you with a `getSummary()` shorthand, directly on the `\Bramus\Reflection\ReflectionClassConstant` instance.
- Provide you with a `getDescription()` shorthand, directly on the `\Bramus\Reflection\ReflectionClassConstant` instance.


### Other Reflection Classes

Other Reflection Classes are not provided. They might be in the future.

## Testing

`bramus/reflection` ships with unit tests using [PHPUnit](https://github.com/sebastianbergmann/phpunit/) `~8.0`.

- If PHPUnit is installed globally run `phpunit` to run the tests.
- If PHPUnit is not installed globally, install it locally throuh composer by running `composer install --dev`. Run the tests themselves by calling `./vendor/bin/phpunit` or using the composer script `composer test`

```
$ composer test
```

## License

`bramus/reflection` is released under the MIT public license. See the enclosed `LICENSE` for details.