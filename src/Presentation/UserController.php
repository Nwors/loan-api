<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Core\Application\Action\User\CreateUser;
use App\Core\Application\Action\User\IssueProduct;
use App\Core\Application\Action\User\PartialUpdateUser;
use App\Core\Application\Common\CommandBus;
use App\Core\Domain\Common\UUID;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'product')]
class UserController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    #[Route('', name: 'user.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);

        $id = UUID::generate();

        $this->commandBus->execute(
            new CreateUser(
                id: $id,
                firstName: (string) $body['firstName'],
                lastName: (string) $body['lastName'],
                age: (int) $body['age'],
                city: (string) $body['city'],
                usState: (string) $body['usState'],
                ssn: (string) $body['ssn'],
                fico: (int) $body['fico'],
                email: (string) $body['email'],
                phone: (string) $body['phone']
            )
        );

        return new Response(
            null,
            Response::HTTP_CREATED,
            ['Location' => '/users/' . $id]
        );
    }

    #[Route('/{userId<.{36}>}', name: 'user.partial-update', methods: ['PATCH'])]
    public function update(Request $request, string $userId): Response
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->execute(
            new PartialUpdateUser(
                userId: $userId,
                firstName: $body['firstName'] ?? null,
                lastName: $body['lastName'] ?? null,
                age: $body['age'] ?? null,
                city: $body['city'] ?? null,
                usState: $body['usState'] ?? null,
                ssn: $body['ssn'] ?? null,
                fico: $body['fico'] ?? null,
                email: $body['email'] ?? null,
                phone: $body['phone'] ?? null
            )
        );

        return new Response(
            null,
            Response::HTTP_NO_CONTENT,
        );
    }

    #[Route('/{userId<.{36}>}/product', name: 'user.product', methods: ['POST'])]
    public function addProduct(Request $request, string $userId): Response
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->execute(
            new IssueProduct(
                userId: $userId,
                productId: (string) $body['productId']
            )
        );

        return new Response(
            null,
            Response::HTTP_CREATED,
        );
    }
}