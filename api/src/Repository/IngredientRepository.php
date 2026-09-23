<?php

namespace App\Repository;

use App\Entity\Ingredient;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function getIngredientsByName(string $name): array
    {
        return $this->createQueryBuilder('ingredient')
            ->where('ingredient.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function saveIngredient(string $name): void
    {
        if ($this->findOneBy(['name' => $name])) {
            return;
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist(new Ingredient($name));
        $entityManager->flush();
    }
}