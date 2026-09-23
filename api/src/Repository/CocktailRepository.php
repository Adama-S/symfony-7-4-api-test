<?php

namespace App\Repository;

use App\Entity\Cocktail;
use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CocktailRepository extends ServiceEntityRepository
{
    private IngredientRepository $ingredientRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cocktail::class);
        $this->ingredientRepository = $this->getEntityManager()->getRepository(Ingredient::class);
    }

    public function getCocktailsByName(string $name): array
    {
        return $this->createQueryBuilder('cocktail')
            ->where('cocktail.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function getCocktailsByIngredientId(int $ingredientId): array
    {
        return $this->createQueryBuilder('cocktail')
            ->innerJoin('cocktail.ingredients', 'ingredient')
            ->where('ingredient.id = :ingredientId')
            ->setParameter('ingredientId', $ingredientId)
            ->getQuery()
            ->getResult();
    }

    public function saveCocktail(string $name, array $ingredientsIds): void
    {
        if ($this->findOneBy(['name' => $name])) {
            return;
        }

        $cocktail = new Cocktail();
        $cocktail->setName($name);

        foreach ($ingredientsIds as $ingredientId) {
            $ingredient = $this->ingredientRepository->find($ingredientId);
            if ($ingredient !== null) {
                $cocktail->addIngredient($ingredient);
            }
        }

        $this->getEntityManager()->persist($cocktail);
        $this->getEntityManager()->flush();
    }
}