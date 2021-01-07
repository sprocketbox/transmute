<?php

namespace Sprocketbox\Transmute\Contracts;

interface Metadata
{
    public function has(string $key): bool;

    public function get(string $key, mixed $default = null): mixed;
}