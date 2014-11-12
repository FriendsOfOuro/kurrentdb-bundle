<?php
namespace EventStore\Bundle\ClientBundle\Tests\Integration;

use EventStore\Bundle\ClientBundle\DependencyInjection\EventStoreClientExtension;
use EventStore\StreamFeed\LinkRelation;
use EventStore\WritableEvent;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EventStoreTest extends TestCase
{
    public function testEventStoreCanCreateAStream()
    {
        $es = $this->getEventStore();

        $event = WritableEvent::newInstance('SomethingHappened', ['foo' => 'bar']);
        $streamName = 'StreamName';

        $es->writeToStream($streamName, $event);
        $es->openStreamFeed($streamName);
    }

    private function getEventStore()
    {
        $loader = new EventStoreClientExtension();

        $builder = new ContainerBuilder();
        $loader->load([], $builder);

        return $builder->get('event_store_client.event_store');
    }
}
