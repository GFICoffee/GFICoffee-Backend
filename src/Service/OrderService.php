<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderedCoffee;
use App\Model\Coffee\CoffeeModel;
use App\Model\Coffee\OrderDto;
use App\Model\User\UserModel;

class OrderService
{
    function convertToDto (Order $order, bool $showUser = false): OrderDto
    {
        $dto = new OrderDto();
        $dto->setId($order->getId());
        $dto->setItems(array_map(function (OrderedCoffee $item): CoffeeModel {
            $coffee = new CoffeeModel();
            $coffee->setId($item->getId());
            $coffee->setQuantity30($item->getQuantity30());
            $coffee->setQuantity50($item->getQuantity50());
            $coffee->setImg($item->getCoffee()->getImg());
            $coffee->setName($item->getCoffee()->getName());
            $coffee->setDesc($item->getCoffee()->getDesc());
            $coffee->setIntensity($item->getCoffee()->getIntensity());
            $coffee->setType($item->getCoffee()->getType());
            $coffee->setUnitPrice($item->getCoffee()->getUnitPrice());

            return $coffee;
        }, $order->getItems()->toArray()));

        if ($showUser) {
            $dto->setUser(new UserModel($order->getUser()));
        }

        return $dto;
    }
}