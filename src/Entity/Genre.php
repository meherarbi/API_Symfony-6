<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ApiResource(
    collectionOperations:['get','post'],
    itemOperations:['get','put','delete'],
    attributes: ["pagination_enabled" => false]
)]
    #[ApiFilter(SearchFilter::class, properties: [
        'name' =>SearchFilter::STRATEGY_PARTIAL,
       
        ])]
        #[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'DESC'])]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['collection','item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['collection','item'])]
    private  $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
