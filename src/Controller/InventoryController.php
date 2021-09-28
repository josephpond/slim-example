<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class InventoryController
{

    /** @var InventoryRepositoryInterface Inventory Repository */
    private $inventoryRepository;

    /**
     * InventoryController constructor.
     * @param InventoryRepositoryInterface $inventoryRepository
     */
    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    /**
     * Provide inventory by item ID.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $id
     *   The ID of the item to request.
     * @return ResponseInterface
     * @throws HttpNotFoundException
     */
    public function getItemAction(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface
    {
        // Generally we would set up some sort of validation system validate input here.
        if (false === is_int($id)) {
            throw new HttpBadRequestException($request, 'Integer expected.');
        }
        $item = $this->inventoryRepository->getItem($id);
        if (null === $item) {
            throw new HttpNotFoundException($request, 'Item not found.');
        }
        return $this->deliver($response, $item);
    }

    /**
     * Provide inventory by name.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $name
     *   The name of the item to request.
     * @return ResponseInterface
     * @throws HttpNotFoundException
     */
    public function itemByNameAction(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $name
    ): ResponseInterface {
        // Generally we would have some sort of input validation system here.
        $item = $this->inventoryRepository->getItemByName($name);
        if (null === $item) {
            throw new HttpNotFoundException($request, 'Item not found.');
        }
        return $this->deliver($response, $item);
    }

    /**
     * Provide items out of stock.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function outOfStockAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $items = $this->inventoryRepository->getOutOfStockItems();
        return $this->deliver($response, $items);
    }

    /**
     * Provide organic options.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function organicAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $items = $this->inventoryRepository->getOrganicItems();
        return $this->deliver($response, $items);
    }

    /**
     * @param ResponseInterface $response
     * @param mixed $payload
     * @param int $status
     * @return ResponseInterface
     */
    private function deliver(ResponseInterface $response, mixed $payload, int $status = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
