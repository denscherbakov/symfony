<?php


namespace App\Controller\Main;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends BaseController
{
	/**
	 * @Route("/post/{id}", name="post_one", requirements={"id"="\d+"})
	 */
	public function readOne($id): Response
	{
		$post = $this->getDoctrine()->getRepository(Post::class)->findBy(['id' => $id]);

		$forRender = parent::renderDefault();
		$forRender['title'] = $post[0]->getTitle();
		$forRender['post'] = $post[0];
		return $this->render('main/post/post.html.twig', $forRender);
	}

}