<?php

namespace App\Controller;

use App\Entity\Coffee;
use App\Entity\Order;
use App\Entity\OrderedCoffee;
use App\Entity\User;
use App\Model\Coffee\CoffeeModel;
use App\Model\Coffee\OrderDto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


class OrdersController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Crée une nouvelle commande.
     *
     * @View()
     * @Post("/api/order")
     *
     * @ParamConverter("data", converter="fos_rest.request_body")
     *
     * @param Request $request
     * @param UserInterface $user
     * @param OrderDto $data
     * @return Order
     */
    public function orderAction(Request $request, UserInterface $user, OrderDto $data)
    {
        $userRepo = $this->em->getRepository(User::class);
        $coffeeRepo = $this->em->getRepository(Coffee::class);
        $order = new Order();
        $order->setUser($userRepo->findOneByUsername($user->getUsername()));
        $order->setItems(new ArrayCollection());

        foreach ($data->getItems() as $item) {
            $orderedCoffee = new OrderedCoffee();
            $orderedCoffee->setOrder($order);
            $orderedCoffee->setCoffee($coffeeRepo->find($item->getId()));
            $orderedCoffee->setQuantity30($item->getQuantity30());
            $orderedCoffee->setQuantity50($item->getQuantity50());
            $order->getItems()->add($orderedCoffee);
        }

        $this->em->merge($order);
        $this->em->flush();
        return $order;
    }
}