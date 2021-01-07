<?php

namespace Sprocketbox\Transmute\Transmutations;

use JsonException;
use Sprocketbox\Transmute\Attributes\Transmutation;
use Sprocketbox\Transmute\Contracts\Metadata;
use Sprocketbox\Transmute\Contracts\ReversibleTransmutation;
use Stringable;

#[Transmutation(name: 'string', requiresMetadata: false, requiredMetadata: [])]
class StringTransmutation implements ReversibleTransmutation
{
    private function getNumberFromString(string $value): float|int|string
    {
        if (str_contains($value, '.')) {
            return (float)$value;
        }

        if (! str_contains($value, 'e')) {
            return (int)$value;
        }

        return $value;
    }

    private function jsonDecodeString(mixed $value)
    {
        try {
            $jsonDecoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

            if ($jsonDecoded) {
                return $jsonDecoded;
            }
        } catch (JsonException $e) {
        }

        return null;
    }

    public function perform(mixed $value, mixed $default = null, Metadata $metadata = null): ?string
    {
        if ($value instanceof Stringable) {
            return $value->__toString();
        }

        if (is_array($value)) {
            try {
                return json_encode($value, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                return $default;
            }
        }

        if (is_object($value)) {
            return serialize($value);
        }

        return (string)$value;
    }

    public function reverse(mixed $value, mixed $default = null, Metadata $metadata = null): mixed
    {
        if (! $value) {
            return $default;
        }

        $unserialised = $this->unserialiseString($value, $metadata);

        if ($unserialised !== false) {
            return $unserialised;
        }

        $jsonDecoded = $this->jsonDecodeString($value);

        if ($jsonDecoded) {
            return $jsonDecoded;
        }

        if (is_numeric($value)) {
            return $this->getNumberFromString($value);
        }

        return $value;
    }

    private function unserialiseString(mixed $value, ?Metadata $metadata)
    {
        return @unserialize($value, [
            'allowed_classes' => $metadata?->get('classes', true),
        ]);
    }
}