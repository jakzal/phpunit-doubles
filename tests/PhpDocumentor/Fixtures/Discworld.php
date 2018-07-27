<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures;

use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Detritus;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\Character\Troll;
use Zalas\PHPUnit\Doubles\Tests\PhpDocumentor\Fixtures\World\Turtle;

class Discworld extends World
{
    use Turtle;

    /**
     * @var Detritus|Troll
     */
    private $detritus;
}
