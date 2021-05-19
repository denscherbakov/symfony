<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Service\FileManagerServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

	/**
	 * @Route("/admin/posts/create", name="admin/posts/create")
	 * @param Request $request
	 * @param FileManagerServiceInterface $fileManagerService
	 * @return RedirectResponse|Response
	 */
	public function create(Request $request, FileManagerServiceInterface $fileManagerService)
    {
		$post = new Post();
		$form = $this->createForm(PostType::class, $post);
		$em = $this->getDoctrine()->getManager();
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$image = $form->get('image')->getData();

			if ($image){
				$fileName = $fileManagerService->imagePostUpload($image);
				$post->setImage($fileName);
			}

			$post->setCreatedAtValue();
			$post->setUpdatedAtValue();
			$post->setIsPublished();
			$em->persist($post);
			$em->flush();

			$this->addFlash('success', 'Post was added.');

			return $this->redirectToRoute('admin/posts_list');
		}

		$forRender = parent::renderDefault();
		$forRender['title'] = 'Create post';
		$forRender['form'] = $form->createView();

		return $this->render('admin/post/form.html.twig', $forRender);
	}

	/**
	 * @Route("/admin/post/delete/{id}", name="admin/post_delete", requirements={"id"="\d+"})
	 */
	public function delete(Post $post, FileManagerServiceInterface $fileManagerService): RedirectResponse
    {
		if (!$post) {
			throw $this->createNotFoundException('No post found');
		}

	    if ($post->getImage()){
		    $fileManagerService->removePostImage($post->getImage());
	    }

		$em = $this->getDoctrine()->getManager();
		$em->remove($post);
		$em->flush();

		$this->addFlash('success', 'Post was removed.');
		return $this->redirectToRoute('admin/posts_list');
	}
}