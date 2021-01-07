<?php

namespace Sprocketbox\Transmute\Transmutations;

use JsonException;
use Sprocketbox\Transmute\Contracts\Arrayable;
use Sprocketbox\Transmute\Contracts\Metadata;
use Sprocketbox\Transmute\Contracts\ReversibleTransmutation;

class ArrayTransmutation implements ReversibleTransmutation
{
    private function createArrayFromIterable(iterable $iterable): array
    {
        $array = [];

        foreach ($iterable as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    private function createArrayFromJson(string $value, mixed $default = null)
    {
        try {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }

        return $default;
    }

    private function hasArrayableClass(?Metadata $metadata): bool
    {
        if ($metadata !== null) {
            $class = $metadata?->get('class');

            return $class !== null && is_subclass_of($class, Arrayable::class);
        }

        return false;
    }

    public function reverse(mixed $value, mixed $default = null, Metadata $metadata = null): mixed
    {
        if ($this->hasArrayableClass($metadata)) {
            return $this->reverseAsArrayable($value, $default, $metadata);
        }

        return $this->reverseAsJson($value);
    }

    public function perform(mixed $value, mixed $default = null, Metadata $metadata = null): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        if (is_iterable($value)) {
            return $this->createArrayFromIterable($value);
        }

        if (is_string($value)) {
            return $this->createArrayFromJson($value, $default);
        }

        return $default;
    }

    private function reverseAsArrayable(mixed $value, mixed $default, Metadata $metadata)
    {
        return $metadata?->get('class')::fromArray($value) ?? $default;
    }

    private function reverseAsJson(mixed $value, mixed $default = null)
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }

        return $default;
    }
}