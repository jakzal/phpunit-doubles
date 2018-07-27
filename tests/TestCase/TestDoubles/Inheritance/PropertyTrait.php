<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Vimes;

trait PropertyTrait
{
    /**
     * @var Vimes|ObjectProphecy
     */
    private $vimes;
}
