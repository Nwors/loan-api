<?php

namespace App\Core\Application\ActionHandler\User;

use App\Core\Application\Action\User\IssueProduct;
use App\Core\Application\Common\CommandHandler;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\ProductRepositoryInterface;
use App\Core\Domain\User\UserRepositoryInterface;

final readonly class IssueProductHandler implements CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function __invoke(IssueProduct $command): void
    {
        $user = $this->userRepository->get(UUID::fromValue($command->userId));
        $product = $this->productRepository->get(UUID::fromValue($command->productId));

        $user->issueProduct($product);

        $this->userRepository->save($user);

        //$this->eventBus->exec($user->releaseEvents());
    }

}