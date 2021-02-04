<?php

namespace Picker\Actors\Bin;

use Dapr\Actors\ActorState;

class BinState extends ActorState {
    /**
     * @var string[] Inventory ids
     */
    public array $items = [];

    /**
     * @var string Where the bin is stored
     */
    public string $shelf = '';
}
