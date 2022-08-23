<?php

namespace Recruitment\ViewCreator;

use Recruitment\Entity\Order;

interface ViewCreatorInterface
{
    /**
     * @param Order $order
     * @return array
     */
    public function getDataForView(Order $order): array;
}
