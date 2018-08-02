# PHPUnit Doubles

[![Build Status](https://travis-ci.com/jakzal/phpunit-doubles.svg?branch=master)](https://travis-ci.com/jakzal/phpunit-doubles)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jakzal/phpunit-doubles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jakzal/phpunit-doubles/?branch=master)

Initialises test doubles in PHPUnit test cases for you.

**Warning**: Note this is a backport of the library originally written for PHP >=7.1.
Things might not work as expected and they definitely work a lot slower than the original version.
If you're interested in optimising this branch, look into the `ReflectionExtractor` class.

## Installation

### Composer

```bash
composer require --dev zalas/phpunit-doubles
```

## Usage

Extend the `Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase` to have your test doubles initialised
in one of the supported test doubling frameworks.

Both the type of test double and the kind of test doubling framework are taken from the property type:

```php
/**
 * @var Vimes|ObjectProphecy
 */
 private $vimes;
```

Currently, two test doubling frameworks are supported:

* [Prophecy](https://github.com/phpspec/prophecy) - `Prophecy\Prophecy\ObjectProphecy` type hint
* [PHPUnit](https://phpunit.de/manual/current/en/test-doubles.html) - `PHPUnit\Framework\MockObject\MockObject` type hint

### Prophecy

```php
<?php

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;

class DiscworldTest extends TestDoublesTestCase
{
    /**
     * @var Vimes|ObjectProphecy
     */
    private $vimes;

    /**
     * @var Nobby|Fred|ObjectProphecy
     */
    private $nobbyAndFred;

    public function test_it_hires_new_recruits_for_nightwatch()
    {
        $discworld = new Discworld($this->vimes->reveal(), $this->nobbyAndFred->reveal());

        $discworld->createNightWatch();

        $this->vimes->recruit($this->nobbyAndFred)->shouldHaveBeenCalled();
    }
}
```

### PHPUnit


```php
<?php

use PHPUnit\Framework\MockObject\MockObject;
use Zalas\PHPUnit\Doubles\TestCase\TestDoublesTestCase;

class DiscworldTest extends TestDoublesTestCase
{
    /**
     * @var Vimes|MockObject
     */
    private $vimes;

    /**
     * @var Nobby|Fred|MockObject
     */
    private $nobbyAndFred;

    public function test_it_hires_new_recruits_for_nightwatch()
    {
        $discworld = new Discworld($this->vimes, $this->nobbyAndFred);

        $this->vimes->expects($this->once())
            ->method('recruit')
            ->with($this->nobbyAndFred);

        $discworld->createNightWatch();
    }
}
```

## Contributing

Please read the [Contributing guide](CONTRIBUTING.md) to learn about contributing to this project.
Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md).
By participating in this project you agree to abide by its terms.
