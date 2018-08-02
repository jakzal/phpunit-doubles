<?php

namespace Zalas\PHPUnit\Doubles\Tests\TestCase\TestDoubles\AmbiguousDouble;

use PHPUnit\Framework\TestCase;

class AmbiguousDoubleTest extends TestCase
{
    public function test_it_throws_an_exception_if_test_double_framework_is_ambiguous()
    {
        if (\method_exists($this, 'expectException')) {
            $this->expectException('LogicException');
        } else {
            $this->setExpectedException('LogicException');
        }

        $runner = new AmbiguousDoubleRunner();
        $runner->callInitialiseTestDoubles();
    }
}
