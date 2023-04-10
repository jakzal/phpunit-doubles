# PHPUnit Doubles

[![Build](https://github.com/jakzal/phpunit-doubles/actions/workflows/build.yml/badge.svg)](https://github.com/jakzal/phpunit-doubles/actions/workflows/build.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jakzal/phpunit-doubles/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/jakzal/phpunit-doubles/?branch=main)

Initialises test doubles in PHPUnit test cases for you.

## Installation

### Composer

```bash
composer require --dev zalas/phpunit-doubles
```

### Phar

The extension is also distributed as a PHAR, which can be downloaded from the most recent
[Github Release](https://github.com/jakzal/phpunit-doubles/releases).

Put the extension in your PHPUnit extensions directory.
Remember to instruct PHPUnit to load extensions in your `phpunit.xml`:

```xml
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         extensionsDirectory="tools/phpunit.d"
>
</phpunit>
```

## Usage

Include the `Zalas\PHPUnit\Doubles\TestCase\ProphecyTestDoubles` or `Zalas\PHPUnit\Doubles\TestCase\PHPUnitTestDoubles`
trait to have your test doubles initialised in one of the supported test doubling frameworks.

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

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\TestCase\ProphecyTestDoubles;

class DiscworldTest extends TestCase
{
    use ProphecyTestDoubles;

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
use PHPUnit\Framework\TestCase;
use Zalas\PHPUnit\Doubles\TestCase\PHPUnitTestDoubles;

class DiscworldTest extends TestCase
{
    use PHPUnitTestDoubles;

    /**
     * @var Vimes|MockObject
     */
    private $vimes;

    /**
     * @var Nobby|MockObject
     */
    private $nobbyAndFred;

    public function test_it_hires_new_recruits_for_nightwatch()
    {
        $discworld = new Discworld($this->vimes, $this->nobby);

        $this->vimes->expects($this->once())
            ->method('recruit')
            ->with($this->nobby);

        $discworld->createNightWatch();
    }
}
```

## Contributing

Please read the [Contributing guide](CONTRIBUTING.md) to learn about contributing to this project.
Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md).
By participating in this project you agree to abide by its terms.
