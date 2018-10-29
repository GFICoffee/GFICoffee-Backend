<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class OrdersController extends AbstractController
{
    /**
     * @View
     * @Get("/api/hello")
     */
    public function helloAction()
    {
        return new JsonResponse('hello world');
    }
}