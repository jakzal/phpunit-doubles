<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\TestCase;

/**
 * @deprecated use one of the replacement traits: ProphecyTestDoubles, PHPUnitTestDoubles.
 */
trait TestDoubles
{
    use ProphecyTestDoubles;
    use PHPUnitTestDoubles;
}
