<?php

namespace Picker\Actors\Inventory;

use Dapr\Actors\ActorState;
use DateTime;

class InventoryState extends ActorState {

    /**
     * @var DateTime The day and time that the inventory arrived at the warehouse
     */
    public DateTime $arrivalTime;

    /**
     * @var string The upc of the inventory item
     */
    public string $upc = '';

    /**
     * @var array extra information about the item
     */
    public array $meta = [];

    /**
     * @var string The bin where this item is stored
     */
    public string $binId = '';

    /**
     * @var string Who the item was received by
     */
    public string $receiverId = '';
}
