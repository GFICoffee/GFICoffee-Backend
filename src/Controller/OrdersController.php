<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;


class OrdersController
{
    /**
     * @View
     * @Get("/hello")
     */
    public function helloAction()
    {

        return new JsonResponse('hello world');
    }
}