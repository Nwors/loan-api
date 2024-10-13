<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Core\Domain\Common\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class DoctrineRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    protected function em(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function repository(string $className): EntityRepository
    {
        return $this->em()->getRepository($className);
    }

    protected function queryBuilder(): QueryBuilder
    {
        return $this->em()->createQueryBuilder();
    }

    protected function internalPersist(AggregateRoot $entity): void
    {
        $this->em()->persist($entity);
    }
}
