<?php

namespace App\Controller;

use App\Entity\Coffee;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
}