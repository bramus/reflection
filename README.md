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

### `ReflectionClass`

The `ReflectionClass` in `bramus/reflection` is inherited from [the PHP `ReflectionClass` class](https://www.php.net/manual/en/class.reflectionclass.php).

```php
<?php

namespace Bramus\Reflection;

class ReflectionClass extends \ReflectionClass
{
	// code here
}
```

Therefore `\Bramus\ReflectionReflectionClass` has all of the functions like [its parent `ReflectionClass` class](https://www.php.net/manual/en/class.reflectionclass.php).

#### Differences with PHP's `ReflectionClass`

When compared to `\ReflectionClass`, `\Bramus\Reflection\ReflectionClass` will:

- Return array of `ReflectionConstant` instances when calling [`getConstants()`](https://www.php.net/manual/en/reflectionclass.getconstants.php).
- Return a `ReflectionConstant` instance when calling [`getConstant()`](https://www.php.net/manual/en/reflectionclass.getconstant.php).

Here's an example comparing `getConstant()`;

- Using PHP's built-in `ReflectionClass`:

	```php
	class Weekday
	{
		// Monday.
		const MONDAY = 1;

		// Tuesday.
		…
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
		// Monday.
		const MONDAY = 1;

		// Tuesday.
		…
	}

	$reflected = new \Bramus\Reflection\ReflectionClass(Weekday::class);
	$constants = $reflected->getConstant('MONDAY');

	var_dump($constant);
	// object(Bramus\Reflection\Type\ReflectionConstant)#40 (3) {
	//   ["name":"Bramus\Reflection\Type\ReflectionConstant":private]=>
	//   string(6) "MONDAY"
	//   ["value":"Bramus\Reflection\Type\ReflectionConstant":private]=>
	//   int(1)
	//   ["description":"Bramus\Reflection\Type\ReflectionConstant":private]=>
	//   string(34) "Monday. The first day of the week."
	// }
	```

The provided `\Bramus\Reflection\Type\ReflectionConstant` class exposes three methods:

- `getName()`: gets the name of the constant.
- `getValue()`: gets the value of the constant.
- `getDescription()`: gets the description of the constant.

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