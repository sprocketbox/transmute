<?php

namespace Sprocketbox\Transmute\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Transmutable
{
    private ?string $name;
    private mixed   $default;
    private array   $metadata;

    public function __construct(?string $name = null, mixed $default = null, array $metadata = [])
    {
        $this->name     = $name;
        $this->default  = $default;
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}