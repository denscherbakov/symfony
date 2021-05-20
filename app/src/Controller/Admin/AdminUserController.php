<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AdminBaseController
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin/users", name="admin/users_list")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Users list';
        $forRender['users'] = $this->userRepository->getAll();
        ;
        return $this->render('admin/user/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/users/create", name="admin/users/create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->setCreateOrUpdate($user);

            $this->addFlash('success', 'User was added.');
            return $this->redirectToRoute('admin/users_list');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create user';
        $forRender['form'] = $form->createView();

        return $this->render('admin/user/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin/user_delete", requirements={"id"="\d+"})
     */
    public function delete(User $user): RedirectResponse
    {
        $this->userRepository->setDelete($user);

        $this->addFlash('success', 'User was removed.');
        return $this->redirectToRoute('admin/users_list');
    }

    /**
     * @Route("/admin/user/update/{id}", name="admin/user_update", requirements={"id"="\d+"})
     */
    public function update(int $id, Request $request): Response
    {
        $user = $this->userRepository->getOne($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->setCreateOrUpdate($user);

            $this->addFlash('success', 'User was updated.');
            return $this->redirectToRoute('admin/users_list');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Update user';
        $forRender['form'] = $form->createView();
        $forRender['user'] = $user;

        return $this->render('admin/user/form.html.twig', $forRender);
    }
}
