<?php

namespace Sprocketbox\Transmute\Metadata;

use Sprocketbox\Transmute\Contracts\Metadata;

class BasicMetadata implements Metadata
{
    private array $metadata;

    public function __construct(array $metadata)
    {
        $this->metadata = $metadata;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->metadata);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    public function __get(string $name)
    {
        return $this->get($name);
    }

    public function __set(string $name, $value): void
    {
        // Intentionally empty
    }

    public function __isset(string $name): bool
    {
        return $this->has($name);
    }
}