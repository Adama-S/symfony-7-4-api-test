<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\PartialSearchFilter;
use ApiPlatform\Metadata\QueryParameter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ApiResource(
    parameters: [
        'name' => new QueryParameter(
            filter: PartialSearchFilter::class,
            property: 'name'
        ),
    ]
)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $name = '';

    #[ORM\ManyToMany(targetEntity: Cocktail::class, inversedBy: 'ingredients')]
    #[ORM\JoinTable(name: 'cocktails_ingredients')]
    private Collection $cocktails;

    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->cocktails = new ArrayCollection();
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

    public function addCocktail(Cocktail $cocktail): void
    {
        if (!$this->cocktails->contains($cocktail)) {
            $this->cocktails[] = $cocktail;
            $cocktail->addIngredient($this);
        }
    }

    public function toArray() : array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}
