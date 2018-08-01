<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Inheritance;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Fred;
use Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures\Nobby;

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
