<?php

namespace Picker\Actors\Bin;

use Dapr\Actors\Actor;
use Dapr\Actors\Attributes\DaprType;

#[DaprType('Bin')]
class BinActor extends Actor implements BinInterface
{
    public function __construct(string $id, private BinState $state)
    {
        parent::__construct($id);
    }

    public function move(string $location): void
    {
        $this->state->shelf = $location;
    }

    public function addItem(string $item): void
    {
        $items = $this->state->items;
        $items[] = $item;
        $this->state->items = array_unique($items);
    }

    public function removeItem(string $item): void
    {
        $items = $this->state->items;
        $items = array_filter($items, fn($i) => $item === $i);
        $this->state->items = $items;
    }

    public function listItems(): array
    {
        return $this->state->items;
    }
}
