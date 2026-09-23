<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\PartialSearchFilter;
use ApiPlatform\Metadata\QueryParameter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CocktailRepository;

#[ORM\Entity(repositoryClass: CocktailRepository::class)]
#[ApiResource(
    parameters: [
        'name' => new QueryParameter(
            filter: PartialSearchFilter::class,
            property: 'name'
        ),
    ]
)]
class Cocktail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $name = '';

    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'cocktails')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIngredientsNamesArray(): array
    {
        $ingredientNames = [];
        foreach ($this->ingredients as $ingredient) {
            if ($ingredient->getName() !== null) {
                $ingredientNames[] = $ingredient->getName();
            }
        }

        return $ingredientNames;
    }

    public function addIngredient(Ingredient $ingredient): void
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->addCocktail($this);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'ingredients' => $this->getIngredientsNamesArray()
        ];
    }
}
