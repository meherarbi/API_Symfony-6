<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass:MovieRepository::class)]
#[ApiResource(
    collectionOperations:['get'=>[
        'normalization_context' =>['groups'=>['collection']]
    ],
    'post',
    'random'=>[
        'controller'=>RandomMovie::class,
        'path'=>'/movies/random',
        'method' =>Request::METHOD_GET,
        'pagination_enabled' =>false
        ]

        
    ],
    itemOperations:['get'=>[
        'normalization_context' =>['groups'=>['item']]
    ],
        'put',
        'delete'
    ],
    
    denormalizationContext:['groups'=>['write']],
    
)]
class Movie
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type:'integer')]
#[Groups(['collection','item'])]
private ?int $id=null;

#[ORM\Column(type:'string', length:255)]
#[Groups(['collection','item','write'])]
private string $title;

#[ORM\Column(type:'integer')]
#[Groups(['collection','item','write'])]
private int $duration;

#[ORM\Column(type:'integer')]
#[Groups(['collection','item','write'])]
private int $productionYear;

#[ORM\Column(type:'text')]
#[Groups(['collection','item','write'])]
private string $synopsis;

#[ORM\ManyToOne(targetEntity:Genre::class)]
#[ORM\JoinColumn(nullable:false)]
#[Groups(['collection','item','write'])]
private Genre $genre;

#[ORM\ManyToMany(targetEntity:Person::class)]
#[ORM\JoinTable(name:'movie_actors')]
#[ApiSubresource]
#[Groups(['item','write'])]
private Collection $actors;

#[ORM\ManyToMany(targetEntity:Person::class)]
#[ORM\JoinTable (name:'movie_directors')]
#[ApiSubresource]
#[Groups(['item','write'])]
private Collection $directors;

public function __construct()
    {
    $this->actors = new ArrayCollection();
    $this->directors = new ArrayCollection();
}

function getId(): ?int
    {
    return $this->id;
}

function getTitle(): ?string
    {
    return $this->title;
}

function setTitle(string $title): self
    {
    $this->title = $title;

    return $this;
}

function getDuration(): ?int
    {
    return $this->duration;
}

function setDuration(int $duration): self
    {
    $this->duration = $duration;

    return $this;
}

function getProductionYear(): ?int
    {
    return $this->productionYear;
}

function setProductionYear(int $productionYear): self
    {
    $this->productionYear = $productionYear;

    return $this;
}

function getSynopsis(): ?string
    {
    return $this->synopsis;
}

function setSynopsis(string $synopsis): self
    {
    $this->synopsis = $synopsis;

    return $this;
}

function getGenre(): ?Genre
    {
    return $this->genre;
}

function setGenre(?Genre $genre): self
    {
    $this->genre = $genre;

    return $this;
}

/**
 * @return Collection<int, Person>
 */
function getActors(): Collection
    {
    return $this->actors;
}

function addActor(Person $actor): self
    {
    if (!$this->actors->contains($actor)) {
        $this->actors[] = $actor;
    }

    return $this;
}

function removeActor(Person $actor): self
    {
    $this->actors->removeElement($actor);

    return $this;
}

/**
 * @return Collection<int, Person>
 */
function getDirectors(): Collection
    {
    return $this->directors;
}

function addDirector(Person $director): self
    {
    if (!$this->directors->contains($director)) {
        $this->directors[] = $director;
    }

    return $this;
}

function removeDirector(Person $director): self
    {
    $this->directors->removeElement($director);

    return $this;
}
}
