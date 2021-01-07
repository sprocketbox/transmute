<?php

namespace Sprocketbox\Transmute\Units;

use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Byte
 *
 * @method static self createFromBytes(int $bytes, ?int $mode = null)
 * @method static self createFromKilobytes(int $kilobytes, ?int $mode = null)
 * @method static self createFromMegabytes(int $megabytes, ?int $mode = null)
 * @method static self createFromGigabytes(int $gigabytes, ?int $mode = null)
 * @method static self createFromTerabytes(int $terabytes, ?int $mode = null)
 * @method static self createFromPetabytes(int $petabytes, ?int $mode = null)
 * @method static self createFromZettabytes(int $zettabytes, ?int $mode = null)
 * @method static self createFromYottabytes(int $yottabytes, ?int $mode = null)
 * @method static self createFromKibibytes(int $kibibytes, ?int $mode = null)
 * @method static self createFromMebibytes(int $mebibytes, ?int $mode = null)
 * @method static self createFromGibibytes(int $gibibytes, ?int $mode = null)
 * @method static self createFromTebibytes(int $tebibytes, ?int $mode = null)
 * @method static self createFromPebibytes(int $pebibytes, ?int $mode = null)
 * @method static self createFromZebibytes(int $zebibytes, ?int $mode = null)
 * @method static self createFromYobibytes(int $yobibytes, ?int $mode = null)
 *
 * @method static self asBytes(?int $mode = null)
 * @method static self asKilobytes(?int $mode = null)
 * @method static self asMegabytes(?int $mode = null)
 * @method static self asGigabytes(?int $mode = null)
 * @method static self asTerabytes(?int $mode = null)
 * @method static self asPetabytes(?int $mode = null)
 * @method static self asZettabytes(?int $mode = null)
 * @method static self asYottabytes(?int $mode = null)
 * @method static self asKibibytes(?int $mode = null)
 * @method static self asMebibytes(?int $mode = null)
 * @method static self asGibibytes(?int $mode = null)
 * @method static self asTebibytes(?int $mode = null)
 * @method static self asPebibytes(?int $mode = null)
 * @method static self asZebibytes(?int $mode = null)
 * @method static self asYobibytes(?int $mode = null)
 *
 * @method static self asBytesFloored(?int $mode = null)
 * @method static self asKilobytesFloored(?int $mode = null)
 * @method static self asMegabytesFloored(?int $mode = null)
 * @method static self asGigabytesFloored(?int $mode = null)
 * @method static self asTerabytesFloored(?int $mode = null)
 * @method static self asPetabytesFloored(?int $mode = null)
 * @method static self asZettabytesFloored(?int $mode = null)
 * @method static self asYottabytesFloored(?int $mode = null)
 * @method static self asKibibytesFloored(?int $mode = null)
 * @method static self asMebibytesFloored(?int $mode = null)
 * @method static self asGibibytesFloored(?int $mode = null)
 * @method static self asTebibytesFloored(?int $mode = null)
 * @method static self asPebibytesFloored(?int $mode = null)
 * @method static self asZebibytesFloored(?int $mode = null)
 * @method static self asYobibytesFloored(?int $mode = null)
 *
 * @method static self asBytesCeiled(?int $mode = null)
 * @method static self asKilobytesCeiled(?int $mode = null)
 * @method static self asMegabytesCeiled(?int $mode = null)
 * @method static self asGigabytesCeiled(?int $mode = null)
 * @method static self asTerabytesCeiled(?int $mode = null)
 * @method static self asPetabytesCeiled(?int $mode = null)
 * @method static self asZettabytesCeiled(?int $mode = null)
 * @method static self asYottabytesCeiled(?int $mode = null)
 * @method static self asKibibytesCeiled(?int $mode = null)
 * @method static self asMebibytesCeiled(?int $mode = null)
 * @method static self asGibibytesCeiled(?int $mode = null)
 * @method static self asTebibytesCeiled(?int $mode = null)
 * @method static self asPebibytesCeiled(?int $mode = null)
 * @method static self asZebibytesCeiled(?int $mode = null)
 * @method static self asYobibytesCeiled(?int $mode = null)
 *
 * @method static self toDecimal()
 * @method static self toBinary()
 *
 * @package Sprocketbox\Transmute\Units
 */
class Byte
{
    /**
     * Modes
     *
     * The mode represents the different ways bytes can be represented/calculated.
     */
    public const DECIMAL = 1000;
    public const BINARY  = 1024;

    /**
     * Magnitude
     *
     * The different magnitudes that bytes can be measured in.
     */
    public const BYTE      = 0;
    public const KILOBYTE  = 1;
    public const MEGABYTE  = 2;
    public const GIGABYTE  = 3;
    public const TERABYTE  = 4;
    public const PETABYTE  = 5;
    public const EXABYTE   = 6;
    public const ZETTABYTE = 7;
    public const YOTTABYTE = 8;

    public const JEDEC21_C = 'JEDEC';
    public const ISO80000  = 'IEC';
    public const IEC80000  = self::ISO80000;

    /**
     * Mapping of Magnitude Names
     *
     * Mapping of magnitude name to numerical magnitude and the mode
     * that the particular name represents.
     */
    public const MAGNITUDES = [
        'bytes'      => [self::BYTE],
        'kilobytes'  => [self::KILOBYTE, self::DECIMAL],
        'megabytes'  => [self::MEGABYTE, self::DECIMAL],
        'gigabytes'  => [self::GIGABYTE, self::DECIMAL],
        'terabytes'  => [self::TERABYTE, self::DECIMAL],
        'petabytes'  => [self::PETABYTE, self::DECIMAL],
        'exabytes'   => [self::EXABYTE, self::DECIMAL],
        'zettabytes' => [self::ZETTABYTE, self::DECIMAL],
        'yottabytes' => [self::YOTTABYTE, self::DECIMAL],
        'kibibyte'   => [self::KILOBYTE, self::BINARY],
        'mebibyte'   => [self::MEGABYTE, self::BINARY],
        'gibibyte'   => [self::GIGABYTE, self::BINARY],
        'tebibyte'   => [self::TERABYTE, self::BINARY],
        'pebibyte'   => [self::PETABYTE, self::BINARY],
        'exbibyte'   => [self::EXABYTE, self::BINARY],
        'zebibyte'   => [self::ZETTABYTE, self::BINARY],
        'yobibyte'   => [self::YOTTABYTE, self::BINARY],
    ];

    /**
     * Mapping of Magnitude Notations
     *
     * Mapping of notations to their decimal and binary notations. The
     * binary notations include both the ISO 80000 and JEDEC21-C notations despite the
     * fact that JEDEC doesn't go past gigabyte.
     */
    public const NOTATIONS = [
        self::BYTE      => [self::DECIMAL => 'B', self::BINARY => [self::ISO80000 => 'B', self::JEDEC21_C => 'B']],
        self::KILOBYTE  => [self::DECIMAL => 'kB', self::BINARY => [self::ISO80000 => 'KiB', self::JEDEC21_C => 'KB']],
        self::MEGABYTE  => [self::DECIMAL => 'MB', self::BINARY => [self::ISO80000 => 'MiB', self::JEDEC21_C => 'MB']],
        self::GIGABYTE  => [self::DECIMAL => 'GB', self::BINARY => [self::ISO80000 => 'GiB', self::JEDEC21_C => 'GB']],
        self::TERABYTE  => [self::DECIMAL => 'TB', self::BINARY => [self::ISO80000 => 'TiB', self::JEDEC21_C => 'TB']],
        self::PETABYTE  => [self::DECIMAL => 'PB', self::BINARY => [self::ISO80000 => 'PiB', self::JEDEC21_C => 'PB']],
        self::EXABYTE   => [self::DECIMAL => 'EB', self::BINARY => [self::ISO80000 => 'EiB', self::JEDEC21_C => 'EB']],
        self::ZETTABYTE => [self::DECIMAL => 'ZB', self::BINARY => [self::ISO80000 => 'ZiB', self::JEDEC21_C => 'ZB']],
        self::YOTTABYTE => [self::DECIMAL => 'YB', self::BINARY => [self::ISO80000 => 'YiB', self::JEDEC21_C => 'YB']],
    ];

    public static bool $caseSensitive = true;

    /**
     * Create a new byte instance.
     *
     * @param int $bytes Bytes as an integer
     * @param int $mode Decimal or binary
     *
     * @return static
     */
    public static function create(
        int $bytes = 0,
        #[ExpectedValues(values: [self::DECIMAL, self::BINARY])]
        int $mode = self::DECIMAL): static
    {
        return new static($bytes, $bytes, self::BYTE, $mode);
    }

    /**
     * @param int|string|float $bytes A parseable representation of the bytes
     * @param int              $magnitude
     * @param int              $mode
     *
     * @return static
     */
    public static function createFrom(
        int|string|float $bytes,
        #[ExpectedValues(values: self::MAGNITUDES)]
        int $magnitude,
        #[ExpectedValues(values: [self::DECIMAL, self::BINARY])]
        int $mode = self::DECIMAL): static
    {
        $original = $bytes;
        $bytes    = self::parseBytes($bytes, $magnitude, $mode);

        return new static($original, $bytes, $magnitude, $mode);
    }

    public static function __callStatic(string $name, array $arguments): static
    {
        if (str_starts_with($name, 'createFrom')) {
            $magnitude = self::getMagnitude(substr($name, strlen('createFrom')));

            if (empty($magnitude)) {
                throw new InvalidArgumentException('Invalid createFrom method call');
            }

            $mode      = $arguments[1] ?? $magnitude[1] ?? self::DECIMAL;
            $magnitude = $magnitude[0];

            return self::createFrom($arguments[0], $magnitude, $mode);
        }
    }

    private static function parseBytes(float|int|string $bytes, int $magnitude, int $mode): int
    {
        if (is_int($bytes)) {
            if ($magnitude === self::BYTE) {
                return $bytes;
            }

            return (int)($bytes * ($mode ** $magnitude));
        }

        if (is_float($bytes)) {
            if ($magnitude === self::BYTE) {
                return (int)floor($bytes);
            }

            return (int)$bytes;
        }

        // TODO: Add parsing of strings
    }

    private static function getMagnitude(string $name): array
    {
        return self::MAGNITUDES[strtolower($name)] ?? [];
    }

    protected float|int|string $original;
    protected int              $bytes     = 0;
    protected int              $magnitude = self::BYTE;
    protected int              $mode      = self::DECIMAL;
    protected array            $totals    = [];

    public function __construct(
        int|float|string $original = 0,
        int $bytes = 0,
        #[ExpectedValues(values: self::MAGNITUDES)]
        int $magnitude = self::BYTE,
        #[ExpectedValues(values: [self::DECIMAL, self::BINARY])]
        int $mode = self::DECIMAL)
    {
        if (! in_array($mode, [self::DECIMAL, self::BYTE])) {
            throw new InvalidArgumentException('Invalid mode: ' . $mode);
        }

        if (! in_array($magnitude, self::MAGNITUDES, true)) {
            throw new InvalidArgumentException('Invalid magnitude: ' . $magnitude);
        }

        $this->original  = $original;
        $this->bytes     = $bytes;
        $this->magnitude = $magnitude;
        $this->mode      = $mode;
        $this->totals    = $this->calculateTotals();
    }

    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'as')) {
            $toMethod = 0;

            if (str_ends_with($name, 'Floored')) {
                $toMethod      = 1;
                $magnitudeName = substr($name, strlen('as'), -strlen('Floored'));
            } else if (str_ends_with($name, 'Ceiled')) {
                $toMethod      = 2;
                $magnitudeName = substr($name, strlen('as'), -strlen('Ceiled'));
            } else {
                $magnitudeName = substr($name, strlen('as'));
            }

            $magnitude = self::getMagnitude($magnitudeName);

            if (empty($magnitude)) {
                throw new InvalidArgumentException('Invalid to method call');
            }

            return match ($toMethod) {
                0 => $this->as($magnitude[0]),
                1 => $this->asFloored($magnitude[0]),
                2 => $this->asCeiled($magnitude[0]),
            };
        }

        if (str_starts_with($name, 'to')) {
            $modeName = substr($name, strlen('to'));
            $clone    = $this->copy();

            $clone->setMode(match ($modeName) {
                'decimal' => self::DECIMAL,
                'binary' => self::BINARY
            });

            return $clone;
        }
    }

    public function as(int $magnitude, ?int $mode = null): float
    {
        if ($magnitude === self::BYTE) {
            return $this->totals[self::BYTE];
        }

        return $this->totals[$magnitude][$mode ?? $this->mode] ?? 0;
    }

    public function asCeiled(int $magnitude, ?int $mode = null): int
    {
        return (int)ceil($this->to($magnitude, $mode));
    }

    public function asFloored(int $magnitude, ?int $mode = null): int
    {
        return (int)floor($this->to($magnitude, $mode));
    }

    public function binary(): static
    {
        return $this->setMode(self::BINARY);
    }

    public function calculate(int $magnitude, int $mode = null): float
    {
        if ($this->bytes === 0) {
            return 0;
        }

        return $this->bytes / (($mode ?? $this->mode) ** $magnitude);
    }

    #[ArrayShape([
        self::BYTE      => "float",
        self::KILOBYTE  => "float",
        self::MEGABYTE  => "float",
        self::GIGABYTE  => "float",
        self::TERABYTE  => "float",
        self::PETABYTE  => "float",
        self::EXABYTE   => "float",
        self::ZETTABYTE => "float",
        self::YOTTABYTE => "float",
    ])]
    private function calculateTotals(): array
    {
        return [
            self::BYTE    => $this->bytes,
            self::DECIMAL => [
                self::KILOBYTE  => $this->calculate(self::KILOBYTE, self::DECIMAL),
                self::MEGABYTE  => $this->calculate(self::MEGABYTE, self::DECIMAL),
                self::GIGABYTE  => $this->calculate(self::GIGABYTE, self::DECIMAL),
                self::TERABYTE  => $this->calculate(self::TERABYTE, self::DECIMAL),
                self::PETABYTE  => $this->calculate(self::PETABYTE, self::DECIMAL),
                self::EXABYTE   => $this->calculate(self::EXABYTE, self::DECIMAL),
                self::ZETTABYTE => $this->calculate(self::ZETTABYTE, self::DECIMAL),
                self::YOTTABYTE => $this->calculate(self::YOTTABYTE, self::DECIMAL),
            ],
            self::BINARY  => [
                self::KILOBYTE  => $this->calculate(self::KILOBYTE, self::DECIMAL),
                self::MEGABYTE  => $this->calculate(self::MEGABYTE, self::DECIMAL),
                self::GIGABYTE  => $this->calculate(self::GIGABYTE, self::DECIMAL),
                self::TERABYTE  => $this->calculate(self::TERABYTE, self::DECIMAL),
                self::PETABYTE  => $this->calculate(self::PETABYTE, self::DECIMAL),
                self::EXABYTE   => $this->calculate(self::EXABYTE, self::DECIMAL),
                self::ZETTABYTE => $this->calculate(self::ZETTABYTE, self::DECIMAL),
                self::YOTTABYTE => $this->calculate(self::YOTTABYTE, self::DECIMAL),
            ],
        ];
    }

    public function copy(): static
    {
        return clone $this;
    }

    public function decimal(): static
    {
        return $this->setMode(self::DECIMAL);
    }

    public function getOriginal(): float|int|string
    {
        return $this->original;
    }

    public function setMode(#[ExpectedValues(values: [self::DECIMAL, self::BINARY])] int $mode): static
    {
        if (! in_array($mode, [self::DECIMAL, self::BYTE])) {
            throw new InvalidArgumentException('Invalid mode: ' . $mode);
        }

        $this->mode = $mode;

        return $this;
    }
}