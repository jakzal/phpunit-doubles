<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\Injector\Fixtures;

class CityWatch
{
    private $cityRecruits;

    public function getCityRecruits()
    {
        return $this->cityRecruits;
    }
}
