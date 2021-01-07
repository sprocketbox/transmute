# Transmute
[![Latest Stable Version](https://poser.pugx.org/sprocketbox/transmute/v/stable.png)](https://packagist.org/packages/sprocketbox/transmute)
[![Latest Unstable Version](https://poser.pugx.org/sprocketbox/transmute/v/unstable.png)](https://packagist.org/packages/sprocketbox/transmute)
[![License](https://poser.pugx.org/sprocketbox/transmute/license.png)](https://packagist.org/packages/sprocketbox/transmute)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sprocketbox/transmute/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sprocketbox/transmute/?branch=main)

- **PHP**: 8+
- **License**: MIT
- **Author**: Ollie Read
- **Author Homepage**: https://sprocketbox.io

Transmute is a simple PHP library for transmuting data between
multiple formats and types.

#### Table of Contents

- [Installing](#installing)
- [Breakdown](#breakdown)
    - [Transmutations](#transmutations)
- [Usage](#usage)
    - [Finding](#finding)
    - [Hydrating](#hydrating)
    - [Belongs To](#belongsto)
    - [Flushing](#flushing)
- [How does it work](#how)
- [Why?](#why)

## Installing
To install this package simply run the following command.

```
composer require sprocketbox/transmute
```

## Breakdown
The following is a breakdown of the terminology and processes
within transmute.

### Transmutor
At the center of this package is the transmutor, responsible
for maintaining a list of registered transmutation and 
performing/delegating the transmutations themselves.

The transmutor class is:

```
Sprocketbox\Transmute\Transmutor
```

### Transmutations
Transmutations are the actions that can be performed on
data, encapsulated within a transmutation class
implementing the following interface:

```
Sprocketbox\Transmute\Contracts\Transmutation
```

Some transmutations are reversible, in which case they
will instead implement the following interface:

```
Sprocketbox\Transmute\Contracts\ReversibleTransmutation
```

This interface extends the main `Transmutation` so all
reversible transmutations are also an instance of the primary
interface.

### Metadata
Sometimes a transmutation will require a certain amount
of context specific metadata. This is provided using a
class implementing the following interface:

```
Sprocketbox\Transmute\Contracts\Metadata
```

This package comes with a basic metadata implementation
that internally stores an array and has the appropriate
magic methods. This class is:

```
Sprocketbox\Transmute\Metadata\BasicMetadata
```

### Transmutable Objects
Transmutable objects are classes that can be transmuted
to another type, typically a primitive type.

When attempting to transmute these objects you do not
need to provide a transmutation name, instead, the 
transmutation will be inferred based on the interface
that it implements.

There are interfaces for all primitive types, except 
`string` which uses the core PHP 8 interface `\Stringable`.
All interfaces exist in the `Sprocketbox\Transmute\Contracts` 
namespace.

| Type | Interface | Method |
|---|---|---|
|`string`|`\Stringable`|`__toString()`|
|`int`|`..\Intable`|`toInt()`|
|`float`|`..\Floatable`|`toFloat()`|
|`array`|`..\Arrayable`|`toArray()`|
|`bool`|`..\Boolable`|`toBool()`|

## Usage
To work with transmute you will need an instance of the
transmutor.

The transmutor is a singleton that can be retrieved with
the following code.

```php
use Sprocketbox\Transmute\Transmutor;

$transmutor = Transmutor::make();
```

Each successive call to this method will return the same 
object. If you wish to replace the current stored instance
you can pass `true` to this method.

### Registering Transmutations
Once you have your transmutation you will need to register
it with the transmutor.

```php
$transmutor->register(MyTransmutation::class, 'my-transmutation');
```

The register method accepts between 1 and 4 arguments.

| Argument | Type | Description|
|---|---|---|
|`$transmutation`|`string|Transmutation`| An instance of or FQN of your transmutation class |
|`$name`|`?string`|The name of the transmutation|
|`$requiresMetadata`|`bool`|Whether or not the transmutation requires metadata, defaults to `false`|
|`$requiredMetadata`|`array`|An array if metadata keys that must be present for this transmutation, defaults to an empty array|

If the `$name` argument is missing, the transmutation must
use the following attribute:

```
Sprocketbox\Transmute\Attributes\Transmutation
```

This attribute has the same signature as the `register()`
method minus the first argument. For example:

```php
#[Transmutation(name: 'string', requiresMetadata: false, requiredMetadata: [])]
class StringTransmutation implements ReversibleTransmutation
{

}
```

### Transmuting values
There are a number of ways to transmute values using the
transmutor.

#### Basic transmuting
To transmute an object implementing one of the interfaces
use the following:

```php
$transmutor->transmute($object);
```

To transmute to a specific type use the following:

```php
$transmutor->transmute($value, 'string');
```

To transmute to a specific type with a default value
use the following:

```php
$transmutor->transmute($value, 'string', 'default');
```

To transmute with metadata use the following:

```php
$transmutor->transmute($value, 'string', 'default', ['key' => 'value']);
```

Since this Library is written for PHP 8 you can use
named attributes:

| Argument | Type | Description|
|---|---|---|
|`$value`|`mixed`|The value to be transmuted|
|`$name`|`?string`|The transmutation to perform|
|`$default`|`mixed`|The default value if the transmutation returns nothing|
|`$metadata`|`Metadata|array`|An array of metadata or a metadata object|

#### Transmuting properties
**NOTE**: This method caches information about the property,
but will use reflection to retrieve this information in
the first place.

If you wish to transmute for a class property you can 
use the following:

```php
$transmutor->property($object, 'property', $value);
```

The `property()` method signature is similiar to the
`transmute()` method.

| Argument | Type | Description|
|---|---|---|
|`$object`|`object|string`|The object or class containing the property|
|`$property`|`string`|The property|
|`$value`|`mixed`|The value to be transmuted|
|`$name`|`?string`|The transmutation to perform|
|`$return`|`bool`|`true` to return the transmuted value, `false` to set. Defaults to `false`|
|`$default`|`mixed`|The default value if the transmutation returns nothing|
|`$metadata`|`Metadata|array`|An array of metadata or a metadata object|

Only the first three arguments are required when 
calling this method.

If no `$name` of a transmutation is provided it can be 
inferred from the property type if there is one. If 
there isn't, an error will be thrown.

It is also possible to provide a transmutation name,
default value and metadata using the following attribute
on the property:

```
Sprocketbox\Transmute\Attributes\Transmutable
```

The transmutable attribute accepts three arguments:

| Argument | Type | Description|
|---|---|---|
|`$name`|`?string`|The transmutation to perform|
|`$default`|`mixed`|The default value if the transmutation returns nothing|
|`$metadata`|`array`|An array of metadata|

Due to a limitation of PHP the metadata must be provided
as an array here.

### Provided transmutation
This package comes with a number of transmutations, each
with their own nuances.

#### array
The `array` transmutation uses the following class:

```
Sprocketbox\Transmute\Transmutations\ArrayTransmutation
```

If the value implements the `Arrayable` interface it
will call the `toArray()` method.

If the value is iterable it will loop through it and
create a new array to be returned.

If the value is a string it will be run through 
`json_decode()` returning the default value if the
call fails.

#### bool
The `bool` transmutation uses the following class:

```
Sprocketbox\Transmute\Transmutations\BoolTransmutation
```

If the value implements the `Boolable` interface it
will call the `toBool()` method.

If the value doesn't implement the above interface it
will simply be cast to `bool` following PHPs rules
for doing so.

#### float
The `float` transmutation uses the following class:

```
Sprocketbox\Transmute\Transmutations\FloatTransmutation
```

If the value implements the `Floatable` interface it
will call the `toFloat()` method.

If the value doesn't implement the above interface it
will simply be cast to `float` following PHPs rules
for doing so.

#### int
The `int` transmutation uses the following class:

```
Sprocketbox\Transmute\Transmutations\IntTransmutation
```

If the value implements the `Intable` interface it
will call the `toInt()` method.

If the value doesn't implement the above interface it
will simply be cast to `int` following PHPs rules
for doing so.

#### string
The `string` transmutation uses the following class:

```
Sprocketbox\Transmute\Transmutations\StringTransmutation
```

If the value implements the `\Stringable` interface it
will call the `__toString()` method.

If the value is an array it will run through 
`json_encode()` returning the default value if the
call fails.

If the value is an object that doesn't implement the
above interface it will be run through `serialize()`, so
will use PHPs serialization functionality.

If none of the above match it will cast to `string` 
following PHPs rules for doing so.