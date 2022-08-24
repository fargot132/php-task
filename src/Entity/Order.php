<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Item;
use Recruitment\ViewCreator\StandardViewCreator;
use Recruitment\ViewCreator\ViewCreatorInterface;

class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Item[]
     */
    private $items;

    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    /**
     * @param ViewCreatorInterface|null $viewCreator
     * @return array
     */
    public function getDataForView(ViewCreatorInterface $viewCreator = null): array
    {
        if (null === $viewCreator) {
            $viewCreator = new StandardViewCreator();
        }
        return $viewCreator->getDataForView($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
