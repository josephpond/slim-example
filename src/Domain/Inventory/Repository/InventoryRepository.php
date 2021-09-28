<?php

namespace App\Domain\Inventory\Repository;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;

class InventoryRepository implements InventoryRepositoryInterface
{
    /**
     * @return array[] The example data.
     */
    private static function getData(): array
    {
        return [
            ['id' => 0, 'name' => 'onion', 'quantity' => 3, 'organic' => true],
            ['id' => 1, 'name' => 'potato', 'quantity' => 0, 'organic' => false],
            ['id' => 2, 'name' => 'tomato', 'quantity' => 2, 'organic' => true],
            ['id' => 3, 'name' => 'carrot', 'quantity' => 8, 'organic' => false],
            ['id' => 4, 'name' => 'cucumber', 'quantity' => 1, 'organic' => true],
            ['id' => 5, 'name' => 'orange', 'quantity' => 4, 'organic' => false],
            ['id' => 6, 'name' => 'apple', 'quantity' => 12, 'organic' => false],
            ['id' => 7, 'name' => 'banana', 'quantity' => 7, 'organic' => false],
            ['id' => 8, 'name' => 'kiwi', 'quantity' => 0, 'organic' => true],
            ['id' => 9, 'name' => 'peach', 'quantity' => 2, 'organic' => false],
            ['id' => 10, 'name' => 'mango', 'quantity' => 0, 'organic' => false],
        ];
    }

    /**
     * @return array
     */
    public function getOutOfStockItems(): array
    {
        return $this->filterByColumn('quantity', 0);
    }

    /**
     * @return array
     */
    public function getOrganicItems(): array
    {
        return $this->filterByColumn('organic', true);
    }

    /**
     * @param int $id
     * @return Inventory|null
     */
    public function getItem(int $id): ?Inventory
    {
        return $this->firstByColumn('id', $id);
    }

    /**
     * @param string $name
     * @return Inventory|null
     */
    public function getItemByName(string $name): ?Inventory
    {
        return $this->firstByColumn('name', $name);
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return Inventory|null
     */
    protected function firstByColumn(string $column, mixed $value): ?Inventory
    {
        $inventory = null;
        $row = array_search($value, array_column(self::getData(), $column));
        if (false !== $row) {
            $inventory = Inventory::create(self::getData()[$row]);
        }
        return $inventory;
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return array
     */
    protected function filterByColumn(string $column, mixed $value): array
    {
        $items = [];
        $rows = array_keys(array_column(self::getData(), $column), $value);
        foreach ($rows as $row) {
            $items[] = Inventory::create(self::getData()[$row]);
        }
        return $items;
    }
}
