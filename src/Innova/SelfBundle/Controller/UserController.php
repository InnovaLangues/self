<?php

namespace Innova\SelfBundle\Controller;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Form\Type\UserBatchType;
use Innova\SelfBundle\Form\Type\UserFilterType;
use Kitpages\DataGridBundle\Grid\Field;
use Kitpages\DataGridBundle\Grid\GridConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;

/**
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 */
class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="admin_user_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $this->get('session')->set('uri.user_list', $request->getUri());

        $repository = $this->getDoctrine()->getRepository('InnovaSelfBundle:User');
        $queryBuilder = $repository->createQueryBuilder('user');

        $filterForm = $this->createForm(new UserFilterType(), null, ['method' => 'GET']);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            $this->addFilters($queryBuilder, $filterForm, [
                'role' => function (QueryBuilder $qb, string $role = null) {
                    switch ($role) {
                        case UserFilterType::FILTER_ROLE_ADMIN:
                            $qb
                                ->andWhere('user.roles LIKE :role')
                                ->setParameter('role', '%ADMIN%');
                            break;
                        case UserFilterType::FILTER_ROLE_NOT_ADMIN:
                            $qb
                                ->andWhere('user.roles NOT LIKE :role')
                                ->setParameter('role', '%ADMIN%');
                            break;
                    }
                },
                'lastLoginOlderThan' => function (QueryBuilder $qb, \DateTime $lastLoginOlderThan = null) {
                    if ($lastLoginOlderThan === null) {
                        return;
                    }

                    $qb
                        ->andWhere('user.lastLogin < :lastLoginOlderThan')
                        ->setParameter('lastLoginOlderThan', $lastLoginOlderThan);
                }
            ]);
        }

        $gridConfig = new GridConfig();
        $gridConfig
            ->setQueryBuilder($queryBuilder)
//            ->setPaginatorConfig((new PaginatorConfig())->setItemCountInPage((int) $request->get('itemPerPage', 100)))
            ->setCountFieldName('user.id')
            ->addField(new Field('user.id', [
                'label' => '#',
                'sortable' => true
            ]))
            ->addField(new Field('user.usernameCanonical', [
                'label' => 'Login',
                'filterable' => true,
                'autoEscape' => false,
                'formatValueCallback' => function ($usernameCanonical) {
                    return '<span class="strip">' . $usernameCanonical . '</span>';
                }
            ]))
            ->addField(new Field('user.emailCanonical', [
                'label' => 'E-mail',
                'filterable' => true
            ]))
            ->addField(new Field('user.firstName', [
                'label' => 'Prénom',
                'filterable' => true
            ]))
            ->addField(new Field('user.lastName', [
                'label' => 'Nom',
                'filterable' => true
            ]))
            ->addField(new Field('user.roles', [
                'label' => 'Admin',
                'autoEscape' => false,
                'formatValueCallback' => function ($roles) {
                    foreach ($roles as $role) {
                        if (strpos($role, 'SUPER_ADMIN') !== false) {
                            return '<span class="label label-default">Super Admin</span>';
                        }

                        if (strpos($role, 'ADMIN') !== false) {
                            return '<span class="label label-default">Admin</span>';
                        }
                    }

                    return '-';
                }
            ]))
            ->addField(new Field('hasCreations', [
                'label' => 'Concepteur',
                'formatValueCallback' => function ($value, $row) {
                    return $this->hasCreations($row['user.id']) ? 'oui' : '-';
                }
            ]))
        ;

        $gridManager = $this->get('kitpages_data_grid.grid_manager');
        $grid = $gridManager->getGrid($gridConfig, $request);

        $batchUsers = [];

        foreach ($grid->getItemList() as $item) {
            $canBeDeleted = !$this->hasCreations($item['user.id']) && !$this->isAdmin($item['user.roles']);

            if (!$canBeDeleted) {
                continue;
            }

            $batchUsers[$item['user.id']] = true;
        }

        $userBatchForm = $this->createUserBatchForm($batchUsers);

        return [
            'grid' => $grid,
            'filterForm' => $filterForm->createView(),
            'userBatchForm' => $userBatchForm->createView()
        ];
    }

    private function addFilters(QueryBuilder $queryBuilder, Form $form, array $mapping): void
    {
        if (!$form->isSubmitted()) {
            return;
        }

        foreach ($mapping as $fieldName => $modifier) {
            $fieldValue = $form->get($fieldName)->getData();
            $modifier($queryBuilder, $fieldValue);
        }
    }

    private $hasCreationsCache = [];
    private function hasCreations(int $userId): bool
    {
        if (!isset($this->hasCreationsCache[$userId])) {
            $questionnaireRepository = $this->getDoctrine()->getRepository(Questionnaire::class);
            $created = $questionnaireRepository->countByAuthor($userId);
            $revised = $questionnaireRepository->countByRevisor($userId);

            $this->hasCreationsCache[$userId] = ($created + $revised) > 0;
        }

        return $this->hasCreationsCache[$userId];
    }

    private function createUserBatchForm(array $users): FormInterface
    {
        return $this->createForm(
            new UserBatchType(),
            ['users' => $users],
            ['action' => $this->generateUrl('admin_user_delete_batch')]
        );
    }

    private function isAdmin(array $roles): bool
    {
        return count(preg_grep('/ADMIN/', $roles)) > 0;
    }

    /**
     * @Route("/admin/users/delete-batch", name="admin_user_delete_batch")
     * @Method("POST")
     */
    public function batchDeleteAction(Request $request)
    {
        $redirection = $this->get('session')->get('uri.user_list', $this->generateUrl('admin_user_index'));
        $form = $this->createForm(new UserBatchType());
        $form->handleRequest($request);

        $userIds = [];

        foreach ($form->get('users') as $userField) {
            $userIds[] = $userField->getName();
        }

        $totalUser = count($userIds);

        if ($totalUser === 0) {
            $this->addFlash('info', "Vous n'avez selectionné aucun utilisateur.");
            return $this->redirect($redirection);
        }

        if (!$request->get('confirm', false)) {
            $users = $this->getDoctrine()->getRepository(User::class)->findByIds($userIds);

            return $this->render('@InnovaSelf/User/delete_confirm.html.twig', [
                'totalUser' => $totalUser,
                'users' => $users,
                'form' => $form->createView()
            ]);
        }

        try {
            $this->getDoctrine()->getRepository('InnovaSelfBundle:User')->remove($userIds);
            $this->addFlash('success', "Les $totalUser utilisateurs que vous avez selectionné ont été supprimés.");
        } catch (ForeignKeyConstraintViolationException $e) {
            throw $e;
            $this->get('logger')->error($e->getMessage());
            $this->addFlash('danger', "Un problème technique empêche un ou plusieurs des utilisateurs selectionnés d'être supprimée.");
        }

        return $this->redirect($redirection);
    }

    /**
     * Lists online users
     *
     * @Route("/admin/users/online", name="admin_user_index_online")
     * @Method("GET")
     * @Template()
     */
    public function indexOnlineAction(Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $users = $this->get('self.user.manager')->getConnected(true);

        return array(
            'entities' => $users
        );
    }

    /**
     * Lists users.
     *
     * @Route("/admin/users/search/", name="admin_user_search")
     * @Method("POST")
     * @Template("InnovaSelfBundle:User:index.html.twig")
     */
    public function searchAction()
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $search = $this->get('request')->request->get('search');
        $userRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User');
        $users = $userRepo->getBySomethingLike($search);

        return array(
            'entities' => $users,
            'subset' => 'Recherche de '.$search,
        );
    }

    /**
     * Displays a user entity.
     *
     * @Route("/admin/user/{id}", name="admin_user_show", requirements={"id": "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $user = $em->getRepository('InnovaSelfBundle:User')->find($id);
        $sessionsWithTraces = $em->getRepository('InnovaSelfBundle:Session')->findWithTraces($user);

        return array(
            'sessions' => $sessionsWithTraces,
            'user' => $user,
        );
    }

    /**
     * Delete trace for a given user and a given session.
     *
     * @Route("/admin/user/{userId}/session/{sessionId}/delete-trace", name="delete-session-trace")
     * @Method("DELETE")
     */
    public function deleteSessionTraceAction(User $user, Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.deletetraceuser');

        if ($this->get('self.trace.manager')->deleteSessionTrace($user, $session)) {
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour la session '.$session->getName().' ('.$session->getTest()->getName().') ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
    }

    /**
     * get traces for a given user and a given session.
     *
     * @Route("/admin/user/{userId}/session/{sessionId}/traces", name="get-session-traces")
     * @Method("GET")
     * @Template("InnovaSelfBundle:User:traces_infos.html.twig")
     */
    public function getSessionTracesAction(User $user, Session $session)
    {
        $traceRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Trace');
        $traces = $traceRepo->findBy(array('user' => $user, 'session' => $session));

        return array(
            'traces' => $traces,
            'user' => $user,
            'session' => $session,
        );
    }

    /**
     * Delete trace for a given user and a given test.
     *
     * @Route("/admin/user/{userId}/delete", name="delete-user")
     * @Method("DELETE")
     */
    public function deleteUserAction(User $user)
    {
        $this->get('innova_voter')->isAllowed('right.deleteuser');

        $this->get('self.user.manager')->deleteUser($user);

        return $this->redirect($this->generateUrl('admin_user_index', array('subset' => 'last')));
    }

    /**
     * @Route("/admin/user/create", name="user_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.createuser');

        $user = new User();
        $form = $this->get('self.user.manager')->handleForm($user, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->add('info', "L'utilisateur a bien été créée");

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/admin/user/{userId}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function editAction(User $user, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.edituser');

        $form = $this->get('self.user.manager')->handleForm($user, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', "L'utilisateur a bien été modifié");

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @Route("/admin/user/{userId}/change-passwd", name="passwd_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:passwd.html.twig")
     */
    public function editPasswordAction(User $user, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.editpassworduser');

        if ($request->isMethod('POST')) {
            $um = $this->get('fos_user.user_manager');
            $user->setPlainPassword($request->request->get('passwd'));
            $um->updateUser($user, true);

            $this->get('session')->getFlashBag()->set('info', 'Le mot de passe a bien été modifié');

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('user' => $user);
    }

    /**
     * @Route("/user/self_display", name="self_user_display")
     * @Method("GET")
     * @Template("InnovaSelfBundle:User:show.html.twig")
     */
    public function selfDisplayAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return array(
            'user' => $user,
        );
    }

    /**
     * @Route("/user/self-edit", name="self_user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function selfEditAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->get('self.user.manager')->handleForm($user, $request);

        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'Les informations ont bien été modifiées');

            return $this->redirect($this->generateUrl('self_user_display'));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @Route("/user/all/rights", name="get_users_for_rights", options={"expose"=true})
     * @Method("GET")
     */
    public function getUserForRights(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $request->query->get('q');
        $users = $em->getRepository('InnovaSelfBundle:User')->getBySomethingLike($query);

        return new JsonResponse(array('users' => $users));
    }
}
