<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dapr\Actors\ActorProxy;
use Dapr\App;
use Dapr\Attributes\FromBody;
use Dapr\PubSub\CloudEvent;
use Dapr\PubSub\Publish;
use Picker\Actors\Bin\BinInterface;
use Picker\Actors\Inventory\InventoryInterface;
use Picker\Actors\Inventory\InventoryReceiveMessage;

$app = App::create(
    configure: fn(\DI\ContainerBuilder $builder) => $builder->addDefinitions(__DIR__.'/config.php')->enableCompilation(__DIR__)
);

$app->post(
    '/receive/{receiverId}/{binId}/{upc}',
    function (string $receiverId, string $upc, string $binId, ActorProxy $actorProxy, \DI\FactoryInterface $factory) {
        $id   = uniqid('inv_');
        $item = $actorProxy->get(InventoryInterface::class, $id);
        $item->receive(new InventoryReceiveMessage($upc, $receiverId, $binId));
        /**
         * @var Publish $publisher
         */
        $publisher = $factory->make(Publish::class, ['pubsub' => 'pubsub']);
        $publisher->topic('receive')->publish(['binId' => $binId, 'itemId' => $id]);

        return ['inventoryId' => $id];
    }
);

$app->post(
    '/events/receivedItem',
    function (#[FromBody] CloudEvent $event, ActorProxy $actorProxy) {
        ['binId' => $binId, 'itemId' => $itemId] = $event->data;
        $bin = $actorProxy->get(BinInterface::class, $binId);
        $bin->addItem($itemId);
    }
);

$app->get(
    '/item/{id}/location',
    function (string $id, ActorProxy $actorProxy) {
        $item = $actorProxy->get(InventoryInterface::class, $id);

        return $item->getLocation();
    }
);

$app->post(
    '/bin/{id}/move',
    function (#[FromBody] string $location, string $id, ActorProxy $actorProxy) {
        $bin = $actorProxy->get(BinInterface::class, $id);
        $bin->move($location);
    }
);

$app->get(
    '/bin/{id}',
    function (ActorProxy $actorProxy, string $id) {
        $bin = $actorProxy->get(BinInterface::class, $id);

        return $bin->listItems();
    }
);

$app->get('/info', fn() => phpinfo(INFO_MODULES | INFO_CONFIGURATION));

$app->start();
