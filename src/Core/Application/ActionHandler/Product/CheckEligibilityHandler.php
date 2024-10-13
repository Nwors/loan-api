<?php

declare(strict_types=1);

namespace App\Core\Application\ActionHandler\Product;

use App\Core\Application\Action\Product\CheckEligibility;
use App\Core\Application\Common\QueryHandler;
use App\Core\Domain\Common\CollectionResponse;
use App\Core\Domain\Common\DomainException;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\ProductRepositoryInterface;
use App\Core\Domain\User\UserRepositoryInterface;

final readonly class CheckEligibilityHandler implements QueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(CheckEligibility $query): CollectionResponse
    {
        $product = $this->productRepository->get(UUID::fromValue($query->productId));
        $user = $this->userRepository->get(UUID::fromValue($query->userId));

        try {
            $product->canBeIssuedTo($user);
            return new CollectionResponse([['result' => true]]);
        } catch (DomainException $exception) {
            return new CollectionResponse([
                [
                    'message' => $exception->getMessage(),
                    'result' => false
                ]
            ]);
        }
    }
}
