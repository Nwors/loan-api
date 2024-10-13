<?php

declare(strict_types=1);

namespace App\Core\Application\ActionHandler\Product;

use App\Core\Application\Action\Product\ViewProduct;
use App\Core\Application\Common\QueryHandler;
use App\Core\Application\DTO\ProductDTO;
use App\Core\Domain\Common\CollectionResponse;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\ProductRepositoryInterface;

final readonly class ViewProductHandler implements QueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function __invoke(ViewProduct $query): CollectionResponse
    {
        $product = $this->productRepository->get(UUID::fromValue($query->productId));

        return new CollectionResponse([ProductDTO::fromObject($product)]);
    }
}
