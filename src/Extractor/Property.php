<?php
declare(strict_types=1);

namespace Zalas\PHPUnit\Doubles\Extractor;

final class Property
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array|string[]
     */
    private $types;

    public function __construct(string $name, array $types)
    {
        $this->name = $name;
        $this->types = $types;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getTypesFiltered(callable $filter): array
    {
        return \array_filter($this->types, $filter);
    }

    public function hasType(string $type): bool
    {
        return \in_array($type, $this->types);
    }
}
