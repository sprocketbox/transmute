<?php

namespace Sprocketbox\Transmute\Transmutations;

use Sprocketbox\Transmute\Contracts\Intable;
use Sprocketbox\Transmute\Contracts\Metadata;
use Sprocketbox\Transmute\Contracts\Transmutation;

class IntTransmutation implements Transmutation
{
    public function perform(mixed $value, mixed $default = null, Metadata $metadata = null): int
    {
        if ($value instanceof Intable) {
            return $value->toInt();
        }

        return (int) $value;
    }
}