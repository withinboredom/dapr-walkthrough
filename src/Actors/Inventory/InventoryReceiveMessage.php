<?php

namespace Picker\Actors\Inventory;

class InventoryReceiveMessage
{
    public function __construct(public string $upc, public string $receiverId, public string $binId)
    {
    }
}
