<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\Fixtures;

class Discworld
{
    /**
     * @var Vimes
     */
    private $vimes;

    /**
     * @var Copper[]
     */
    private $coppers;

    public function __construct(Vimes $vimes, array $coppers)
    {
        $this->vimes = $vimes;
        $this->coppers = $coppers;
    }

    public function createNightWatch()/*: void*/
    {
        foreach ($this->coppers as $copper) {
            $this->vimes->recruit($copper);
        }
    }
}
