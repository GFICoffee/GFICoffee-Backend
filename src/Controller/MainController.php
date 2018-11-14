<?php

namespace App\Controller;

use App\Entity\Coffee;
use App\Entity\User;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


class MainController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var AuthService */
    private $authService;

    /**
     * @var JWTTokenManagerInterface
     */
    private $tokenManager;

    public function __construct(EntityManagerInterface $em,
                                AuthService $authService,
    JWTTokenManagerInterface $tokenManager
)
    {
        $this->em = $em;
        $this->authService = $authService;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @View
     * @Route("/")
     */
    public function rootAction()
    {
        return new JsonResponse('It works');
    }

    /**
     * Obtient la liste des cafés
     *
     * @View()
     * @Get("/api/coffee/list")
     *
     * @return Coffee[]
     */
    public function coffeeListAction()
    {
        $coffeeRepo = $this->em->getRepository(Coffee::class);

        return $coffeeRepo->findAll();
    }

    /**
     * @View()
     * @Get("/api/login")
     *
     * @return RedirectResponse
     */
    public function loginAction()
    {
        return new RedirectResponse($this->authService->getAuthorizationUrl());
    }

    /**
     * @View()
     * @Get("/api/authorize")
     *
     * @return string
     */
    public function authorizeAction(Request $request)
    {
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-[]{};:"<>?,./';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $oauthCode = $request->get('code');
        $this->authService->setCode($oauthCode);
        $userInfo = $this->authService->getUserInfo();

        // Find user from sub, create if doesn't exists.
        $userRepo = $this->em->getRepository(User::class);
        /** @var UserInterface|null $user */
        $user = $userRepo->findOneBySub($userInfo['sub']);

        if (!$user) {
            $user = new User();
            $user->setSub($userInfo['sub']);
            $user->setUsername($userInfo['email']);
            $user->setEmail($userInfo['email']);
            $user->setFirstname($userInfo['given_name']);
            $user->setLastname($userInfo['family_name']);
            $user->setRoles(array('ROLE_USER'));
            $user->setPlainPassword(generateRandomString());
        }

        $user->setLastLogin(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();
        $jwt = $this->tokenManager->create($user);
        return $jwt;
    }
}