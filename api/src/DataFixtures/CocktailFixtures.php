<?php

namespace App\DataFixtures;

use App\Entity\Cocktail;
use App\Entity\Ingredient;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CocktailFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $menthe = $this->getReference(
            IngredientFixtures::MENTHE_REFERENCE,
            Ingredient::class
        );
        $citronVert = $this->getReference(
            IngredientFixtures::CITRON_VERT_REFERENCE,
            Ingredient::class
        );
        $eauGazeuse = $this->getReference(
            IngredientFixtures::EAU_GAZEUSE_REFERENCE,
            Ingredient::class
        );
        $fraise = $this->getReference(
            IngredientFixtures::FRAISE_REFERENCE,
            Ingredient::class
        );
        $jusAnanas = $this->getReference(
            IngredientFixtures::JUS_ANANAS_REFERENCE,
            Ingredient::class
        );

        $mojito= new Cocktail();
        $mojito->setName('Mojito');
        $mojito->addIngredient($menthe);
        $mojito->addIngredient($citronVert);
        $mojito->addIngredient($eauGazeuse);

        $mojitoFraise = new Cocktail();
        $mojitoFraise->setName('Mojito fraise');
        $mojitoFraise->addIngredient($fraise);
        $mojitoFraise->addIngredient($eauGazeuse);

        $pinacolada = new Cocktail();
        $pinacolada->setName('Pinacolada');
        $pinacolada->addIngredient($jusAnanas);
        $pinacolada->addIngredient($eauGazeuse);

        $manager->persist($mojito);
        $manager->persist($mojitoFraise);
        $manager->persist($pinacolada);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}