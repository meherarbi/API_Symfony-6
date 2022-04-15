<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne', name:'app_blog')]
class PersonneController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    private const PUB = [
        [
            'id' => 1,
            'name' => 'blog',
            'prenom' => 'title',
            'age' => 20,
            'proffesion' => 'prof',
            'avatar' => 'meher.jpg',

        ],
        [
            'id' => 2,
            'name' => 'Pers',
            'prenom' => 'tit',
            'age' => 20,
            'proffesion' => 'prof',
            'avatar' => 'meher.jpg',
        ],
        [
            'id' => 3,
            'name' => 'bls',
            'prenom' => 'titl',
            'age' => 20,
            'proffesion' => 'met',
            'avatar' => 'meher.jpg',
        ],
    ];

    #[Route('/', name:'list_person')]
function listPerson()
    {
    return new JsonResponse(self::PUB);
}
#[Route('/{id}', name:'person_id', requirements:['id' => '\d+'])]
function PersonById($id)
    {
    return new JsonResponse(self::PUB[array_search
        ($id,
            array_column(self::PUB, 'id'))
    ]);
}

#[Route('/addPerson', name:'add_Person', methods:['POST'])]
function personAdd(Request $request)
    {
    $serializer = $this->GET->serializer('serializer');
    $Personnes = $serializer->deserialize($request->getcontent(), Person::class, 'json');
    $this->entityManager->persist($Personnes);
    $this->entityManager->flush();
    return $this->json($Personnes);
}
}
