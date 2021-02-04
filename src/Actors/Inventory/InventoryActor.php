<?php

namespace Picker\Actors\Inventory;

use Dapr\Actors\Actor;
use Dapr\Actors\Attributes\DaprType;

#[DaprType('Inventory')]
class InventoryActor extends Actor implements InventoryInterface
{
    public function __construct(string $id, private InventoryState $state)
    {
        parent::__construct($id);
    }

    public function receive(InventoryReceiveMessage $message): void
    {
        $this->state->arrivalTime = new \DateTime();
        $this->state->receiverId = $message->receiverId;
        $this->state->binId = $message->binId;
        $this->state->upc = $message->upc;
    }

    public function getLocation(): string
    {
        return $this->state->binId;
    }
}
