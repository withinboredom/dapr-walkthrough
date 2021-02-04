<?php

use Dapr\Actors\Generators\ProxyFactory;
use Dapr\PubSub\Subscription;

use Picker\Actors\Bin\BinActor;
use Picker\Actors\Inventory\InventoryActor;

use function DI\env;

return [
    // Generate a new proxy on each request - recommended for development
    'dapr.actors.proxy.generation' => env('GENERATION_MODE', ProxyFactory::GENERATED),

    // put any subscriptions here
    'dapr.subscriptions'           => [
        \DI\factory(
            fn() => new Subscription('pubsub', 'receive', '/events/receivedItem')
        ),
    ],

    // if this service will be hosting any actors, add them here
    'dapr.actors'                  => [InventoryActor::class, BinActor::class],

    // if this service will be hosting any actors, configure how long until dapr should consider an actor idle
    'dapr.actors.idle_timeout'     => null,

    // if this service will be hosting any actors, configure how often dapr will check for idle actors
    'dapr.actors.scan_interval'    => null,

    // if this service will be hosting any actors, configure how long dapr will wait for an actor to finish during drains
    'dapr.actors.drain_timeout'    => null,

    // if this service will be hosting any actors, configure if dapr should wait for an actor to finish
    'dapr.actors.drain_enabled'    => null,

    // you shouldn't have to change this, but the setting is here if you need to
    'dapr.port'                    => env('DAPR_HTTP_PORT', '3500'),

    // add any custom serialization routines here
    'dapr.serializers.custom'      => [],

    // add any custom deserialization routines here
    'dapr.deserializers.custom'    => [],
];
