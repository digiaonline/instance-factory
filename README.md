# instance-factory

A factory for constructing objects from arrays of properties

## Installation

```bash
composer require digiaonline/instance-factory
```

## Usage

```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

/**
 * A class we want to be able to instantiate. Phpdoc has been left out for brevity.
 */
class Person
{
    private $name;

    private $age;

    private $optionalInformation;

    public function __construct(string $name, int $age, ?string $optionalInformation = null)
    {
        $this->name                = $name;
        $this->age                 = $age;
        $this->optionalInformation = $optionalInformation;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getOptionalInformation(): ?string
    {
        return $this->optionalInformation;
    }
}

// Create one instance where we skip the optional information
/** @var Person $personOne */
$personOne = \Digia\InstanceFactory\InstanceFactory::fromProperties(Person::class, [
    'name' => 'John Smith',
    'age'  => 34,
]);

/** @var Person $personOne */
$personTwo = \Digia\InstanceFactory\InstanceFactory::fromProperties(Person::class, [
    'name'                => 'Alice Smith',
    'age'                 => 33,
    'optionalInformation' => 'Not related to John Smith',
]);
```

This will print the following:

```
class Person#5 (3) {
  private $name =>
  string(10) "John Smith"
  private $age =>
  int(34)
  private $optionalInformation =>
  NULL
}

class Person#2 (3) {
  private $name =>
  string(11) "Alice Smith"
  private $age =>
  int(33)
  private $optionalInformation =>
  string(25) "Not related to John Smith"
}
``` 

## License

MIT
