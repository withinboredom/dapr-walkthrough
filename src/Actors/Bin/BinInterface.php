<?php

namespace Picker\Actors\Bin;

use Dapr\Actors\Attributes\DaprType;

#[DaprType('Bin')]
interface BinInterface
{
    public function move(string $location): void;
    public function addItem(string $item): void;
    public function removeItem(string $item): void;
    public function listItems(): array;
}
