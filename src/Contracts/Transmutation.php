<?php

namespace Sprocketbox\Transmute\Contracts;

interface Transmutation
{
    public function perform(mixed $value, mixed $default = null, Metadata $metadata = null): mixed;
}