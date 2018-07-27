<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\Fixtures\Nobby;

class BaseTestCase extends TestCase
{
    /**
     * @var Fred|ObjectProphecy
     */
    protected $fred;

    /**
     * @var Nobby|ObjectProphecy
     */
    private $nobby;

    public function getNobby()
    {
        return $this->nobby;
    }
}
