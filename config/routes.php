<?php

use App\Controller\InventoryController;
use Slim\App;

return function (App $app) {
    $app->get('/items/id/{id}', [InventoryController::class, 'getItemAction']);
    $app->get('/items/name/{name}', [InventoryController::class, 'itemByNameAction']);
    $app->get('/items/out-of-stock', [InventoryController::class, 'outOfStockAction']);
    $app->get('/items/organic', [InventoryController::class, 'organicAction']);
};
