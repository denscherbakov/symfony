<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
	/**
	 * @var PostRepositoryInterface
	 */
	private PostRepositoryInterface $postRepository;

	public function __construct(PostRepositoryInterface $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	/**
     * @Route("/admin/posts", name="admin/posts_list")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Posts list';
        $forRender['posts'] = $this->postRepository->getAll();;
        return $this->render('admin/post/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/posts/{id}", name="admin/post_one", requirements={"id"="\d+"})
     */
    public function readOne(int $id): Response
    {
        $post = $this->postRepository->getOne($id);

        $forRender = parent::renderDefault();
        $forRender['title'] = $post->getTitle();
        $forRender['post'] = $post;
        return $this->render('admin/post/post.html.twig', $forRender);
    }

	/**
	 * @Route("/admin/posts/create", name="admin/posts/create")
	 * @param Request $request
	 * @return RedirectResponse|Response
	 */
	public function create(Request $request)
    {
		$post = new Post();
		$form = $this->createForm(PostType::class, $post);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$image = $form->get('image')->getData();
			$this->postRepository->setCreate($post, $image);

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
	public function delete(Post $post): RedirectResponse
    {
	    $this->postRepository->setDelete($post);

		$this->addFlash('success', 'Post was removed.');
		return $this->redirectToRoute('admin/posts_list');
	}
}