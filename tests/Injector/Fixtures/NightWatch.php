<?php

namespace Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures;

class NightWatch extends CityWatch
{
    private $commander;

    public function __construct($commander = null)
    {
        $this->commander = $commander;
    }

    public function getCommander()
    {
        return $this->commander;
    }
}
