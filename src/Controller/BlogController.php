<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name:'app_blog')]
class BlogController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    private const POSTS = [
        [
            'id' => 1,
            'na' => 'blog',
            'title' => 'title',

        ],
        [
            'id' => 2,
            'slug' => 'hello',
            'title' => 'Hello_World',
        ],
        [
            'id' => 3,
            'slug' => 'blog',
            'title' => 'title',
        ],
    ];

    #[Route('/', name:'list')]
function list() {
    return new JsonResponse(self::POSTS);
}
#[Route('/{id}', name:'blog_id', requirements:['id' => '\d+'])]
function blogById($id)
    {
    return new JsonResponse(self::POSTS[array_search
        ($id,
            array_column(self::POSTS, 'id'))
    ]);
}

#[Route('/add', name:'add', methods:['POST'])]
function blogAdd(Request $request)
    {
    $serializer = $this->GET->serializer('serializer');
    $blogPost = $serializer->deserialize($request->getcontent(), Blog::class, 'json');
    $this->entityManager->persist($blogPost);
    $this->entityManager->flush();
    return $this->json($blogPost);
}
}
