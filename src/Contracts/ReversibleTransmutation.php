<?php

namespace Sprocketbox\Transmute\Contracts;

interface ReversibleTransmutation extends Transmutation
{
    public function reverse(mixed $value, mixed $default = null, Metadata $metadata = null): mixed;
}