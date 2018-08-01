<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures;

class NightWatch
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

    public function getRecruits()
    {
        return \property_exists($this, 'recruits') ? $this->recruits : null;
    }
}
