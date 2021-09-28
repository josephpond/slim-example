<?php

namespace App\Domain\Inventory\Repository;

use App\Domain\Inventory\Model\Inventory;

interface InventoryRepositoryInterface
{
    public function getOutOfStockItems(): array;

    public function getOrganicItems(): array;

    public function getItem(int $id): ?Inventory;

    public function getItemByName(string $name): ?Inventory;
}
