<?php

namespace App\Domain\Inventory\Model;

class Inventory implements \JsonSerializable
{
    /**
     * @var array Model properties
     */
    private array $properties;

    public static function create(array $data): Inventory
    {
        return new self($data['id'], $data['name'], $data['quantity'], $data['organic']);
    }

    public function __construct($id, $name, $quantity, $organic)
    {
        $this->properties = compact('id', 'name', 'quantity', 'organic');
    }

    public function __get(string $name): mixed
    {
        return $this->properties[$name];
    }

    public function __set(string $name, mixed $value): void
    {
        if (array_key_exists($name, $this->properties)) {
            $this->properties[$name] = $value;
        }
    }

    /**
     * @return array Properties for serialization.
     */
    public function jsonSerialize(): array
    {
        return $this->properties;
    }
}
