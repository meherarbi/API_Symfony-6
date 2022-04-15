<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:PersonRepository::class)]
#[ApiResource(
    collectionOperations:['get','post'],
    itemOperations:['get','put','delete'],
    attributes: ["pagination_enabled" => false]
)]
    #[ApiFilter(SearchFilter::class, properties: [
        'firstname' =>SearchFilter::STRATEGY_PARTIAL,
        'lastname' =>SearchFilter::STRATEGY_PARTIAL,
        ])]
        #[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'DESC'])]
class Person
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type:'integer')]
private $id;

#[ORM\Column(type:'string', length:255)]

private $firstname;

#[ORM\Column(type:'string', length:255)]
private $lastname;



function getId(): ?int
    {
    return $this->id;
}

function getFirstname(): ?string
    {
    return $this->firstname;
}

function setFirstname(string $firstname): self
    {
    $this->firstname = $firstname;

    return $this;
}

function getLastname(): ?string
    {
    return $this->lastname;
}

function setLastname(string $lastname): self
    {
    $this->lastname = $lastname;

    return $this;
}



}
