<?php

namespace App\Controller\Main;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['is_published' => 1]);

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Posts list';
        $forRender['posts'] = $posts;

        return $this->render('main/index.html.twig', $forRender);
    }
}
