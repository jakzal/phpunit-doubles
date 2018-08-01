<?php

namespace Zalas\PHPUnit\Doubles\Injector;

interface Injector
{
    public function inject(/*object */$target, /*string */$property, /*object */$object)/*: void*/;
}
