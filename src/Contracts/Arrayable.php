<?php

namespace Sprocketbox\Transmute\Contracts;

interface Arrayable
{
    public function toArray(): array;

    public static function fromArray(array $array): mixed;
}