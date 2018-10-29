<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\User\UserModel;
use App\Model\User\UserWithPasswordModel;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{
    /** @var UserManagerInterface */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @View()
     * @Post("/api/register")
     *
     * @ParamConverter("data", converter="fos_rest.request_body")
     *
     * @return UserModel
     */
    public function registerAction(Request $request, UserWithPasswordModel $data)
    {
        /**
         * @var User $user
         */
        $user = $this->userManager->findUserByEmail($data->getEmail());

        if ($user) {
            throw new \InvalidArgumentException("Cet email est déjà référencé !");
        } else {
            /** @var User $user */
            $user = $this->userManager->createUser();

            $user->setRoles(['ROLE_USER']);
            $user->setEnabled(true);
            $user->setPlainPassword($data->getPassword());
            $user->setUsername($data->getEmail());

            if ($data->getEmail()) {
                $user->setEmail($data->getEmail());
            }

            $this->userManager->updateUser($user);
            return $data;
        }
    }
}