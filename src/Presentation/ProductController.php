<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Core\Application\Action\Product\CheckEligibility;
use App\Core\Application\Action\Product\ViewProduct;
use App\Core\Application\Common\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product')]
class ProductController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    #[Route('/{productId<.{36}>}', name: 'product.view', methods: ['GET'])]
    public function view(string $productId): JsonResponse
    {
        $response = $this->queryBus->query(
            new ViewProduct(
                productId: $productId
            )
        );

        return new JsonResponse($response->result(), Response::HTTP_OK);
    }

    #[Route('/{productId<.{36}>}/eligibility', name: 'product.eligibility', methods: ['GET'])]
    public function productEligibility(Request $request, string $productId): JsonResponse
    {
        $response = $this->queryBus->query(
            new CheckEligibility(
                productId: $productId,
                userId: $request->query->get('user_id')
            )
        );

        return new JsonResponse(
            $response->result(),
            Response::HTTP_OK,
        );
    }
}
