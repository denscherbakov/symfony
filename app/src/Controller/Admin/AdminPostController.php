<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    /**
     * @Route("/admin/posts", name="admin/posts_list")
     */
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Posts list';
        $forRender['posts'] = $posts;
        return $this->render('admin/post/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/posts/{id}", name="admin/post_one", requirements={"id"="\d+"})
     */
    public function readOne($id): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->findBy(['id' => $id]);

        $forRender = parent::renderDefault();
        $forRender['title'] = $post[0]->getTitle();
        $forRender['post'] = $post[0];
        return $this->render('admin/post/post.html.twig', $forRender);
    }
}