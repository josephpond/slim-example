<?php

use App\Domain\Inventory\Repository\InventoryRepository;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAnnotations(false);

// Autowire InventoryRepositoryInterface
$containerBuilder->addDefinitions([
    InventoryRepositoryInterface::class => \DI\Create(InventoryRepository::class),
]);

$app = Bridge::create($containerBuilder->build());

// Separate out middleware and routing to avoid clutter.
(require __DIR__ . '/../config/middleware.php')($app);
(require __DIR__ . '/../config/routes.php')($app);

$app->run();
