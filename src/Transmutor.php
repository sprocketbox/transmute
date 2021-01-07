<?php

namespace Sprocketbox\Transmute;

use InvalidArgumentException;
use ReflectionClass;
use Sprocketbox\Transmute\Contracts\Arrayable;
use Sprocketbox\Transmute\Contracts\Boolable;
use Sprocketbox\Transmute\Contracts\Floatable;
use Sprocketbox\Transmute\Contracts\Intable;
use Sprocketbox\Transmute\Contracts\Metadata;
use Sprocketbox\Transmute\Contracts\ReversibleTransmutation;
use Sprocketbox\Transmute\Contracts\Transmutation;
use Sprocketbox\Transmute\Metadata\BasicMetadata;

class Transmutor
{
    private static Transmutor $instance;

    public static function make(bool $new = false): static
    {
        if ($new || ! (self::$instance instanceof self)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Registered transmutations.
     *
     * @var array<string, \Sprocketbox\Transmute\Contracts\Transmutation>
     */
    private array $transmutations = [];

    /**
     * @var array<string, \Sprocketbox\Transmute\Attributes\Transmutation>
     */
    private array $transmutationConfig = [];

    /**
     * Transmutations that are reversible.
     *
     * @var array<string>
     */
    private array $reversibleTransmutations = [];

    private function buildMetadata(array|Metadata $metadata): ?Metadata
    {
        if ($metadata instanceof Metadata) {
            return $metadata;
        }

        return ! empty($metadata) ? new BasicMetadata($metadata) : null;
    }

    private function getTransmutationConfig(Transmutation $transmutation, ?string $name, bool $requiresMetadata, array $requiredMetadata): Attributes\Transmutation
    {
        $attributes = (new ReflectionClass($transmutation))->getAttributes(Attributes\Transmutation::class);

        if ($attributes) {
            /** @noinspection PhpIncompatibleReturnTypeInspection */
            return $attributes[0];
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Cannot register a transmutation without a name');
        }

        return $this->makeTransmutationConfig($name, $requiresMetadata, $requiredMetadata);
    }

    public function hasTransmutation(string $name): bool
    {
        return $this->transmutations[$name] !== null;
    }

    private function inferTransmutationFromObject(object $value): ?string
    {
        if ($value instanceof Arrayable) {
            return 'array';
        }

        if ($value instanceof Boolable) {
            return 'bool';
        }

        if ($value instanceof Floatable) {
            return 'float';
        }

        if ($value instanceof Intable) {
            return 'int';
        }

        if ($value instanceof \Stringable) {
            return 'string';
        }

        return null;
    }

    private function makeTransmutation(Transmutation|string $transmutation): Transmutation
    {
        if ($transmutation instanceof Transmutation) {
            return $transmutation;
        }

        if (! is_subclass_of($transmutation, Transmutation::class)) {
            throw new InvalidArgumentException('Transmutations must implement the \'' . Transmutation::class . '\' interface');
        }

        return new $transmutation;
    }

    private function makeTransmutationConfig(?string $name, bool $requiresMetadata, array $requiredMetadata): Attributes\Transmutation
    {
        return new Attributes\Transmutation($name, $requiresMetadata, $requiredMetadata);
    }

    public function register(Transmutation|string $transmutation, ?string $name = null, bool $requiresMetadata = false, array $requiredMetadata = []): static
    {
        $transmutation = $this->makeTransmutation($transmutation);
        $config        = $this->getTransmutationConfig($transmutation, $name, $requiresMetadata, $requiredMetadata);

        $this->transmutations[$config->getName()]      = $transmutation;
        $this->transmutationConfig[$config->getName()] = $config;

        if ($transmutation instanceof ReversibleTransmutation) {
            $this->reversibleTransmutations[] = $config->getName();
        }

        return $this;
    }

    public function transmute(mixed $value, ?string $name = null, mixed $default = null, Metadata|array $metadata = [])
    {
        if (is_object($value) && $name === null) {
            $name = $this->inferTransmutationFromObject($value);
        }

        if (! $this->hasTransmutation($name)) {
            throw new InvalidArgumentException('Invalid transmutation \'' . $name . '\'');
        }

        $metadata = $this->buildMetadata($metadata);

        $this->transmutationConfig[$name]->validateMetadata($metadata);

        $transmutation = $this->transmutations[$name];

        return $transmutation->perform($value, $default, $metadata);
    }

    public function property(object|string $object, string $property, mixed $value, ?string $name = null, mixed $default = null, bool $return = false, Metadata|array $metadata = [])
    {

    }
}