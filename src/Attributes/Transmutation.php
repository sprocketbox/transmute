<?php

namespace Sprocketbox\Transmute\Attributes;

use Attribute;
use InvalidArgumentException;
use Sprocketbox\Transmute\Contracts\Metadata;

#[Attribute(Attribute::TARGET_CLASS)]
class Transmutation
{
    private string $name;
    private bool   $requiresMetadata;
    private array  $requiredMetadata;

    public function __construct(string $name, bool $requiresMetadata = false, array $requiredMetadata = [])
    {
        $this->name             = $name;
        $this->requiresMetadata = $requiresMetadata;
        $this->requiredMetadata = $requiredMetadata;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getRequiredMetadata(): array
    {
        return $this->requiredMetadata;
    }

    /**
     * @return bool
     */
    public function requiresMetadata(): bool
    {
        return $this->requiresMetadata;
    }

    private function throwRequiredMetadataException(): void
    {
        throw new InvalidArgumentException('The ' . $this->getName() . ' transmutation requires metadata options: ' . implode(', ', $this->requiredMetadata));
    }

    public function validateMetadata(?Metadata $metadata = null): void
    {
        if ($metadata !== null) {
            foreach ($this->getRequiredMetadata() as $required) {
                if (! $metadata->has($required)) {
                    $this->throwRequiredMetadataException();
                }
            }
        } else if ($this->requiresMetadata) {
            throw new InvalidArgumentException('The ' . $this->getName() . ' transmutation requires metadata');
        }
    }
}