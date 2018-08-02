<?php

namespace Zalas\PHPUnit\Doubles\Extractor;

interface Extractor
{
    /**
     * Extracts properties from the given object and filters them out.
     *
     * @param object   $object the object to extract properties from
     * @param callable $filter a callback to filter properties with
     *
     * The filter callback should receive an instance of Property and decide whether the property should be kept or not.
     *
     * @return Property[]
     */
    public function extract(/*object */$object, /*callable */$filter)/*: array*/;
}
